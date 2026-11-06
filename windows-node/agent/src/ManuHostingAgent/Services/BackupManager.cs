using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;
using ManuHostingAgent.Models;
using SharpCompress.Archives;
using SharpCompress.Archives.Zip;
using SharpCompress.Common;

namespace ManuHostingAgent.Services;

public class BackupManager : IBackupManager
{
    private readonly IConfiguration _configuration;
    private readonly ILogger<BackupManager> _logger;
    private readonly IFileManager _fileManager;
    private readonly IProcessManager _processManager;
    private readonly string _backupsDir;
    private readonly string _serversDir;
    private readonly int _maxBackupsPerServer;
    private readonly string[] _excludePatterns;

    public BackupManager(
        IConfiguration configuration,
        ILogger<BackupManager> logger,
        IFileManager fileManager,
        IProcessManager processManager)
    {
        _configuration = configuration;
        _logger = logger;
        _fileManager = fileManager;
        _processManager = processManager;
        _backupsDir = _configuration["Agent:BackupsDir"] ?? @"D:\ManuHosting\backups";
        _serversDir = _configuration["Agent:ServersDir"] ?? @"D:\ManuHosting\servers";
        _maxBackupsPerServer = _configuration.GetValue<int>("Backup:MaxBackupsPerServer", 10);
        _excludePatterns = _configuration.GetSection("Backup:ExcludePatterns").Get<string[]>() 
            ?? new[] { "*.log", "*.tmp", "cache/*", "plugins/dynmap/*", "logs/*", "crash-reports/*" };
    }

    public async Task<BackupInfo> CreateBackupAsync(string serverUuid, string? name = null)
    {
        var backupId = Guid.NewGuid().ToString("N")[..12];
        var timestamp = DateTime.UtcNow.ToString("yyyyMMdd_HHmmss");
        var backupName = name ?? $"backup_{timestamp}";
        var backupFileName = $"{backupName}_{backupId}.zip";
        var backupPath = Path.Combine(_backupsDir, serverUuid, backupFileName);

        var backupInfo = new BackupInfo
        {
            Id = backupId,
            ServerUuid = serverUuid,
            Name = backupName,
            Path = backupPath,
            Status = "running",
            CreatedAt = DateTime.UtcNow
        };

        try
        {
            _logger.LogInformation("Creating backup {BackupId} for server {ServerUuid}", backupId, serverUuid);

            // Create backup directory
            var backupDir = Path.Combine(_backupsDir, serverUuid);
            if (!Directory.Exists(backupDir))
            {
                Directory.CreateDirectory(backupDir);
            }

            var serverDir = Path.Combine(_serversDir, serverUuid);
            if (!Directory.Exists(serverDir))
            {
                throw new DirectoryNotFoundException($"Server directory not found: {serverDir}");
            }

            // Create zip archive with exclusions
            using (var archive = ZipArchive.Create())
            {
                AddDirectoryToArchive(archive, serverDir, "", serverUuid);
                archive.SaveTo(backupPath, new ZipArchiveOptions { CompressionLevel = CompressionLevel.Fastest });
            }

            var fileInfo = new FileInfo(backupPath);
            backupInfo.Size = fileInfo.Length;
            backupInfo.Status = "completed";
            backupInfo.CompletedAt = DateTime.UtcNow;

            _logger.LogInformation("Backup {BackupId} completed, size: {Size} bytes", backupId, backupInfo.Size);

            // Cleanup old backups
            await CleanupOldBackupsAsync(serverUuid);

            return backupInfo;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating backup for {ServerUuid}", serverUuid);
            backupInfo.Status = "failed";
            backupInfo.ErrorMessage = ex.Message;
            backupInfo.CompletedAt = DateTime.UtcNow;
            return backupInfo;
        }
    }

    private void AddDirectoryToArchive(SharpCompress.Archives.Zip.ZipArchive archive, string sourceDir, string relativePath, string serverUuid)
    {
        foreach (var file in Directory.GetFiles(sourceDir))
        {
            var fileName = Path.GetFileName(file);
            var fileRelativePath = Path.Combine(relativePath, fileName).Replace("\\", "/");
            
            // Check exclude patterns
            if (ShouldExclude(fileRelativePath))
            {
                continue;
            }

            archive.AddEntry(fileRelativePath, file);
        }

        foreach (var dir in Directory.GetDirectories(sourceDir))
        {
            var dirName = Path.GetFileName(dir);
            var dirRelativePath = Path.Combine(relativePath, dirName).Replace("\\", "/");
            
            if (ShouldExclude(dirRelativePath))
            {
                continue;
            }

            AddDirectoryToArchive(archive, dir, dirRelativePath, serverUuid);
        }
    }

    private bool ShouldExclude(string relativePath)
    {
        foreach (var pattern in _excludePatterns)
        {
            var regexPattern = pattern
                .Replace(".", "\\.")
                .Replace("*", ".*")
                .Replace("?", ".");
            
            if (System.Text.RegularExpressions.Regex.IsMatch(relativePath, regexPattern, System.Text.RegularExpressions.RegexOptions.IgnoreCase))
            {
                return true;
            }
        }
        return false;
    }

    private async Task CleanupOldBackupsAsync(string serverUuid)
    {
        try
        {
            var backupDir = Path.Combine(_backupsDir, serverUuid);
            if (!Directory.Exists(backupDir))
            {
                return;
            }

            var backups = Directory.GetFiles(backupDir, "*.zip")
                .Select(f => new FileInfo(f))
                .OrderByDescending(f => f.CreationTimeUtc)
                .Skip(_maxBackupsPerServer)
                .ToList();

            foreach (var backup in backups)
            {
                try
                {
                    backup.Delete();
                    _logger.LogDebug("Deleted old backup: {File}", backup.Name);
                }
                catch (Exception ex)
                {
                    _logger.LogWarning(ex, "Failed to delete old backup: {File}", backup.Name);
                }
            }
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error cleaning up old backups for {ServerUuid}", serverUuid);
        }
    }

    public async Task<bool> RestoreBackupAsync(string serverUuid, string backupId)
    {
        try
        {
            _logger.LogInformation("Restoring backup {BackupId} for server {ServerUuid}", backupId, serverUuid);

            var backupDir = Path.Combine(_backupsDir, serverUuid);
            var backupFiles = Directory.GetFiles(backupDir, $"*{backupId}*.zip");
            
            if (backupFiles.Length == 0)
            {
                _logger.LogError("Backup not found: {BackupId}", backupId);
                return false;
            }

            var backupFile = backupFiles[0];
            var serverDir = Path.Combine(_serversDir, serverUuid);

            // Stop server if running
            var isRunning = await _processManager.IsServerRunningAsync(serverUuid);
            if (isRunning)
            {
                await _processManager.StopServerAsync(serverUuid);
                await Task.Delay(2000);
            }

            // Clear server directory (keep backup folder)
            if (Directory.Exists(serverDir))
            {
                foreach (var item in Directory.GetFileSystemEntries(serverDir))
                {
                    try
                    {
                        if (Directory.Exists(item))
                            Directory.Delete(item, true);
                        else
                            File.Delete(item);
                    }
                    catch (Exception ex)
                    {
                        _logger.LogWarning(ex, "Failed to delete {Item} during restore", item);
                    }
                }
            }

            // Extract backup
            using (var archive = ZipArchive.Open(backupFile))
            {
                foreach (var entry in archive.Entries)
                {
                    if (!entry.IsDirectory)
                    {
                        var entryPath = Path.Combine(serverDir, entry.Key);
                        var entryDir = Path.GetDirectoryName(entryPath);
                        if (!string.IsNullOrEmpty(entryDir) && !Directory.Exists(entryDir))
                        {
                            Directory.CreateDirectory(entryDir);
                        }
                        entry.WriteToFile(entryPath, new ExtractionOptions { Overwrite = true });
                    }
                }
            }

            _logger.LogInformation("Backup {BackupId} restored successfully for server {ServerUuid}", backupId, serverUuid);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error restoring backup {BackupId} for {ServerUuid}", backupId, serverUuid);
            return false;
        }
    }

    public async Task<bool> DeleteBackupAsync(string serverUuid, string backupId)
    {
        try
        {
            var backupDir = Path.Combine(_backupsDir, serverUuid);
            var backupFiles = Directory.GetFiles(backupDir, $"*{backupId}*.zip");
            
            foreach (var file in backupFiles)
            {
                File.Delete(file);
            }

            _logger.LogInformation("Deleted backup {BackupId} for server {ServerUuid}", backupId, serverUuid);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting backup {BackupId} for {ServerUuid}", backupId, serverUuid);
            return false;
        }
    }

    public async Task<List<BackupInfo>> ListBackupsAsync(string serverUuid)
    {
        var backups = new List<BackupInfo>();

        try
        {
            var backupDir = Path.Combine(_backupsDir, serverUuid);
            if (!Directory.Exists(backupDir))
            {
                return backups;
            }

            var files = Directory.GetFiles(backupDir, "*.zip")
                .Select(f => new FileInfo(f))
                .OrderByDescending(f => f.CreationTimeUtc)
                .ToList();

            foreach (var file in files)
            {
                // Parse backup info from filename: backup_YYYYMMDD_HHMMSS_id.zip
                var nameWithoutExt = Path.GetFileNameWithoutExtension(file.Name);
                var parts = nameWithoutExt.Split('_');
                
                string backupId = parts.Length > 0 ? parts[^1] : Guid.NewGuid().ToString("N")[..12];
                string backupName = parts.Length > 2 ? string.Join("_", parts.Take(parts.Length - 1)) : nameWithoutExt;

                backups.Add(new BackupInfo
                {
                    Id = backupId,
                    ServerUuid = serverUuid,
                    Name = backupName,
                    Path = file.FullName,
                    Size = file.Length,
                    Status = "completed",
                    CreatedAt = file.CreationTimeUtc,
                    CompletedAt = file.CreationTimeUtc
                });
            }
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error listing backups for {ServerUuid}", serverUuid);
        }

        return backups;
    }

    public async Task<BackupInfo?> GetBackupAsync(string serverUuid, string backupId)
    {
        var backups = await ListBackupsAsync(serverUuid);
        return backups.FirstOrDefault(b => b.Id == backupId);
    }

    public async Task<bool> ScheduleBackupAsync(string serverUuid, string cronExpression, string? name = null)
    {
        // This would integrate with Windows Task Scheduler
        // For now, return true as placeholder
        _logger.LogInformation("Scheduled backup for server {ServerUuid} with cron: {Cron}", serverUuid, cronExpression);
        return true;
    }

    public async Task<bool> CancelScheduledBackupAsync(string serverUuid, string backupId)
    {
        // This would integrate with Windows Task Scheduler
        _logger.LogInformation("Cancelled scheduled backup {BackupId} for server {ServerUuid}", backupId, serverUuid);
        return true;
    }
}
