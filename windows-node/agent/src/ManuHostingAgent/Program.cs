using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Configuration;
using ManuHostingAgent.Services;

var builder = Host.CreateApplicationBuilder(args);

// Configuration
builder.Configuration
    .AddJsonFile("appsettings.json", optional: true, reloadOnChange: true)
    .AddYamlFile("config.yaml", optional: true, reloadOnChange: true)
    .AddEnvironmentVariables();

// Logging
builder.Logging.ClearProviders();
builder.Logging.AddConsole();
builder.Logging.AddEventLog();
builder.Logging.SetMinimumLevel(LogLevel.Information);

// Services
builder.Services.AddHttpClient<IControlPlaneApi, ControlPlaneApi>(client =>
{
    client.Timeout = TimeSpan.FromSeconds(30);
})
.AddTransientHttpErrorPolicy(p => p.WaitAndRetryAsync(3, _ => TimeSpan.FromSeconds(2)));

builder.Services.AddSingleton<IProcessManager, ProcessManager>();
builder.Services.AddSingleton<IFileManager, FileManager>();
builder.Services.AddSingleton<IBackupManager, BackupManager>();
builder.Services.AddSingleton<IIdleShutdownManager, IdleShutdownManager>();
builder.Services.AddHostedService<AgentWorker>();
builder.Services.AddHostedService<HeartbeatService>();
builder.Services.AddHostedService<CommandPollingService>();

// Build and run
var host = builder.Build();
await host.RunAsync();
