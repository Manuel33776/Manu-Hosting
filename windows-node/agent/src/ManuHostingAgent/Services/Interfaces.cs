using ManuHostingAgent.Models;

namespace ManuHostingAgent.Services;

public interface IControlPlaneApi
{
    Task<bool> RegisterNodeAsync(string nodeId, string token, NodeResources resources);
    Task<bool> SendHeartbeatAsync(string nodeId, string token, NodeResources resources, List<ServerStatus> servers);
    Task<List<CommandRequest>> PollCommandsAsync(string nodeId, string token);
    Task<bool> SendCommandResultAsync(string nodeId, string token, CommandResult result);
    Task<bool> SendServerStatusAsync(string nodeId, string token, ServerStatus status);
    Task<bool> SendInstallProgressAsync(string nodeId, string token, string serverUuid, int progress, string message);
    Task<bool> TestConnectionAsync();
}

public interface IProcessManager
{
    Task<bool> StartServerAsync(ServerConfig config);
    Task<bool> StopServerAsync(string serverUuid, int timeoutSeconds = 30);
    Task<bool> RestartServerAsync(string serverUuid);
    Task<bool> SendConsoleCommandAsync(string serverUuid, string command);
    Task<ServerStatus?> GetServerStatusAsync(string serverUuid);
    Task<List<ServerStatus>> GetAllServerStatusesAsync();
    Task<bool> IsServerRunningAsync(string serverUuid);
    Task<int?> GetServerPidAsync(string serverUuid);
}

public interface IFileManager
{
    Task<bool> CreateServerDirectoryAsync(string serverUuid);
    Task<bool> DeleteServerDirectoryAsync(string serverUuid);
    Task<bool> WriteFileAsync(string serverUuid, string relativePath, string content);
    Task<string?> ReadFileAsync(string serverUuid, string relativePath);
    Task<bool> DeleteFileAsync(string serverUuid, string relativePath);
    Task<List<string>> ListFilesAsync(string serverUuid, string directory = "");
    Task<bool> UploadFileAsync(string serverUuid, string relativePath, Stream content);
    Task<Stream?> DownloadFileAsync(string serverUuid, string relativePath);
    Task<bool> CreateDirectoryAsync(string serverUuid, string relativePath);
    Task<bool> DirectoryExistsAsync(string serverUuid, string relativePath);
    Task<bool> FileExistsAsync(string serverUuid, string relativePath);
    Task<long> GetDirectorySizeAsync(string serverUuid, string relativePath = "");
    Task<bool> ZipDirectoryAsync(string serverUuid, string sourcePath, string destinationPath);
    Task<bool> UnzipFileAsync(string serverUuid, string zipPath, string destinationPath);
}

public interface IBackupManager
{
    Task<BackupInfo> CreateBackupAsync(string serverUuid, string? name = null);
    Task<bool> RestoreBackupAsync(string serverUuid, string backupId);
    Task<bool> DeleteBackupAsync(string serverUuid, string backupId);
    Task<List<BackupInfo>> ListBackupsAsync(string serverUuid);
    Task<BackupInfo?> GetBackupAsync(string serverUuid, string backupId);
    Task<bool> ScheduleBackupAsync(string serverUuid, string cronExpression, string? name = null);
    Task<bool> CancelScheduledBackupAsync(string serverUuid, string backupId);
}

public interface IIdleShutdownManager
{
    Task StartMonitoringAsync(string serverUuid, int timeoutSeconds);
    Task StopMonitoringAsync(string serverUuid);
    Task<bool> IsMonitoringAsync(string serverUuid);
    Task<int> GetRemainingTimeAsync(string serverUuid);
    event EventHandler<IdleShutdownEventArgs> OnIdleShutdown;
}

public class IdleShutdownEventArgs : EventArgs
{
    public string ServerUuid { get; set; } = string.Empty;
    public string Reason { get; set; } = string.Empty;
}
