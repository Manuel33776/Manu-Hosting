using System.IO.Compression;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;
using ManuHostingAgent.Models;
using SharpCompress.Archives;
using SharpCompress.Archives.Zip;
using SharpCompress.Common;

namespace ManuHostingAgent.Services;

public class FileManager : IFileManager
{
    private readonly IConfiguration _configuration;
    private readonly ILogger<FileManager> _logger;
    private readonly string _serversDir;
    private readonly string[] _blockedPaths = { "..", "~", "$" };

    public FileManager(IConfiguration configuration, ILogger<FileManager> logger)
    {
        _configuration = configuration;
        _logger = logger;
        _serversDir = _configuration["Agent:ServersDir"] ?? @"D:\ManuHosting\servers";
    }

    public async Task<bool> CreateServerDirectoryAsync(string serverUuid)
    {
        try
        {
            var dir = GetServerDirectory(serverUuid);
            if (!Directory.Exists(dir))
            {
                Directory.CreateDirectory(dir);
                _logger.LogInformation("Created server directory: {Dir}", dir);
            }
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating server directory for {Uuid}", serverUuid);
            return false;
        }
    }

    public async Task<bool> DeleteServerDirectoryAsync(string serverUuid)
    {
        try
        {
            var dir = GetServerDirectory(serverUuid);
            if (Directory.Exists(dir))
            {
                Directory.Delete(dir, true);
                _logger.LogInformation("Deleted server directory: {Dir}", dir);
            }
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting server directory for {Uuid}", serverUuid);
            return false;
        }
    }

    public async Task<bool> WriteFileAsync(string serverUuid, string relativePath, string content)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            var directory = Path.GetDirectoryName(fullPath);
            if (!string.IsNullOrEmpty(directory) && !Directory.Exists(directory))
            {
                Directory.CreateDirectory(directory);
            }

            await File.WriteAllTextAsync(fullPath, content);
            _logger.LogDebug("Wrote file: {Path}", fullPath);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error writing file {Path} for {Uuid}", relativePath, serverUuid);
            return false;
        }
    }

    public async Task<string?> ReadFileAsync(string serverUuid, string relativePath)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            if (!File.Exists(fullPath))
            {
                return null;
            }

            return await File.ReadAllTextAsync(fullPath);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error reading file {Path} for {Uuid}", relativePath, serverUuid);
            return null;
        }
    }

    public async Task<bool> DeleteFileAsync(string serverUuid, string relativePath)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            if (File.Exists(fullPath))
            {
                File.Delete(fullPath);
                _logger.LogDebug("Deleted file: {Path}", fullPath);
            }
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting file {Path} for {Uuid}", relativePath, serverUuid);
            return false;
        }
    }

    public async Task<List<string>> ListFilesAsync(string serverUuid, string directory = "")
    {
        try
        {
            var baseDir = GetServerDirectory(serverUuid);
            var targetDir = string.IsNullOrEmpty(directory) ? baseDir : GetSafePath(serverUuid, directory);

            if (!Directory.Exists(targetDir))
            {
                return new List<string>();
            }

            var files = Directory.GetFileSystemEntries(targetDir, "*", SearchOption.TopDirectoryOnly)
                .Select(f => Path.GetRelativePath(baseDir, f))
                .Where(f => !IsBlockedPath(f))
                .ToList();

            return files;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error listing files for {Uuid}", serverUuid);
            return new List<string>();
        }
    }

    public async Task<bool> UploadFileAsync(string serverUuid, string relativePath, Stream content)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            var directory = Path.GetDirectoryName(fullPath);
            if (!string.IsNullOrEmpty(directory) && !Directory.Exists(directory))
            {
                Directory.CreateDirectory(directory);
            }

            using (var fileStream = File.Create(fullPath))
            {
                await content.CopyToAsync(fileStream);
            }

            _logger.LogDebug("Uploaded file: {Path}", fullPath);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error uploading file {Path} for {Uuid}", relativePath, serverUuid);
            return false;
        }
    }

    public async Task<Stream?> DownloadFileAsync(string serverUuid, string relativePath)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            if (!File.Exists(fullPath))
            {
                return null;
            }

            var memoryStream = new MemoryStream();
            using (var fileStream = File.OpenRead(fullPath))
            {
                await fileStream.CopyToAsync(memoryStream);
            }
            memoryStream.Position = 0;
            return memoryStream;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error downloading file {Path} for {Uuid}", relativePath, serverUuid);
            return null;
        }
    }

    public async Task<bool> CreateDirectoryAsync(string serverUuid, string relativePath)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            if (!Directory.Exists(fullPath))
            {
                Directory.CreateDirectory(fullPath);
            }
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating directory {Path} for {Uuid}", relativePath, serverUuid);
            return false;
        }
    }

    public async Task<bool> DirectoryExistsAsync(string serverUuid, string relativePath)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            return Directory.Exists(fullPath);
        }
        catch
        {
            return false;
        }
    }

    public async Task<bool> FileExistsAsync(string serverUuid, string relativePath)
    {
        try
        {
            var fullPath = GetSafePath(serverUuid, relativePath);
            return File.Exists(fullPath);
        }
        catch
        {
            return false;
        }
    }

    public async Task<long> GetDirectorySizeAsync(string serverUuid, string relativePath = "")
    {
        try
        {
            var baseDir = GetServerDirectory(serverUuid);
            var targetDir = string.IsNullOrEmpty(relativePath) ? baseDir : GetSafePath(serverUuid, relativePath);

            if (!Directory.Exists(targetDir))
            {
                return 0;
            }

            long size = 0;
            foreach (var file in Directory.GetFiles(targetDir, "*", SearchOption.AllDirectories))
            {
                if (!IsBlockedPath(Path.GetRelativePath(baseDir, file)))
                {
                    var info = new FileInfo(file);
                    size += info.Length;
                }
            }

            return size;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error getting directory size for {Uuid}", serverUuid);
            return 0;
        }
    }

    public async Task<bool> ZipDirectoryAsync(string serverUuid, string sourcePath, string destinationPath)
    {
        try
        {
            var sourceDir = GetSafePath(serverUuid, sourcePath);
            var destFile = GetSafePath(serverUuid, destinationPath);

            if (!Directory.Exists(sourceDir))
            {
                _logger.LogError("Source directory does not exist: {Path}", sourceDir);
                return false;
            }

            var destDir = Path.GetDirectoryName(destFile);
            if (!string.IsNullOrEmpty(destDir) && !Directory.Exists(destDir))
            {
                Directory.CreateDirectory(destDir);
            }

            using (var archive = ZipArchive.Create())
            {
                archive.AddAllFromDirectory(sourceDir);
                archive.SaveTo(destFile, new ZipArchiveOptions { CompressionLevel = CompressionLevel.Fastest });
            }

            _logger.LogInformation("Created zip archive: {Dest}", destFile);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error zipping directory {Path} for {Uuid}", sourcePath, serverUuid);
            return false;
        }
    }

    public async Task<bool> UnzipFileAsync(string serverUuid, string zipPath, string destinationPath)
    {
        try
        {
            var zipFile = GetSafePath(serverUuid, zipPath);
            var destDir = GetSafePath(serverUuid, destinationPath);

            if (!File.Exists(zipFile))
            {
                _logger.LogError("Zip file does not exist: {Path}", zipFile);
                return false;
            }

            if (!Directory.Exists(destDir))
            {
                Directory.CreateDirectory(destDir);
            }

            using (var archive = ZipArchive.Open(zipFile))
            {
                foreach (var entry in archive.Entries)
                {
                    if (!entry.IsDirectory)
                    {
                        var entryPath = Path.Combine(destDir, entry.Key);
                        var entryDir = Path.GetDirectoryName(entryPath);
                        if (!string.IsNullOrEmpty(entryDir) && !Directory.Exists(entryDir))
                        {
                            Directory.CreateDirectory(entryDir);
                        }
                        entry.WriteToFile(entryPath, new ExtractionOptions { Overwrite = true });
                    }
                }
            }

            _logger.LogInformation("Extracted zip archive: {Zip} to {Dest}", zipFile, destDir);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error unzipping file {Path} for {Uuid}", zipPath, serverUuid);
            return false;
        }
    }

    private string GetServerDirectory(string serverUuid)
    {
        return Path.Combine(_serversDir, serverUuid);
    }

    private string GetSafePath(string serverUuid, string relativePath)
    {
        // Normalize path
        relativePath = relativePath.Replace("/", "\\").TrimStart('\\', '/');
        
        // Check for path traversal attempts
        if (IsBlockedPath(relativePath))
        {
            throw new UnauthorizedAccessException($"Blocked path: {relativePath}");
        }

        var baseDir = GetServerDirectory(serverUuid);
        var fullPath = Path.GetFullPath(Path.Combine(baseDir, relativePath));

        // Ensure the path is within the server directory
        var baseDirFull = Path.GetFullPath(baseDir);
        if (!fullPath.StartsWith(baseDirFull, StringComparison.OrdinalIgnoreCase))
        {
            throw new UnauthorizedAccessException($"Path traversal attempt: {relativePath}");
        }

        return fullPath;
    }

    private bool IsBlockedPath(string path)
    {
        var normalized = path.Replace("/", "\\").ToLowerInvariant();
        return _blockedPaths.Any(b => normalized.Contains(b.ToLowerInvariant())) ||
               normalized.StartsWith("..") ||
               normalized.Contains("..\\") ||
               normalized.Contains("\\..");
    }
}
