<#
.SYNOPSIS
    Manu Hosting Windows Node Agent Installer
    Installs the agent as a Windows Service on the DL580

.DESCRIPTION
    This script installs the Manu Hosting Windows Node Agent including:
    - .NET 8 Runtime (if not present)
    - Java Runtime (for Minecraft servers)
    - Agent service configuration
    - Firewall rules
    - Directory structure and ACLs
    - Windows Service registration

.PARAMETER InstallDir
    Installation directory (default: D:\ManuHosting)

.PARAMETER NodeId
    Unique node identifier (default: dl580-node-01)

.PARAMETER NodeToken
    Secure token for authentication with control plane

.PARAMETER ControlPlaneUrl
    URL of the Debian control plane (default: https://manu-hosting.de)

.PARAMETER ApiPort
    API port on control plane (default: 8443)

.EXAMPLE
    .\install.ps1 -NodeToken "secure-token-here" -ControlPlaneUrl "https://manu-hosting.de"

.EXAMPLE
    .\install.ps1 -InstallDir "E:\ManuHosting" -NodeId "dl580-node-02" -NodeToken "token"
#>

param(
    [Parameter(Mandatory=$false)]
    [string]$InstallDir = "D:\ManuHosting",
    
    [Parameter(Mandatory=$false)]
    [string]$NodeId = "dl580-node-01",
    
    [Parameter(Mandatory=$true)]
    [string]$NodeToken,
    
    [Parameter(Mandatory=$false)]
    [string]$ControlPlaneUrl = "https://manu-hosting.de",
    
    [Parameter(Mandatory=$false)]
    [int]$ApiPort = 8443,
    
    [Parameter(Mandatory=$false)]
    [switch]$SkipDotNet,
    
    [Parameter(Mandatory=$false)]
    [switch]$SkipJava,
    
    [Parameter(Mandatory=$false)]
    [switch]$Force
)

$ErrorActionPreference = "Stop"

# Colors for output
$green = [ConsoleColor]::Green
$yellow = [ConsoleColor]::Yellow
$red = [ConsoleColor]::Red
$cyan = [ConsoleColor]::Cyan

function Write-Log {
    param([string]$Message, [ConsoleColor]$Color = [ConsoleColor]::White)
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    Write-Host "[$timestamp] $Message" -ForegroundColor $Color
}

function Write-Success { param([string]$Message) Write-Log "✓ $Message" $green }
function Write-Warning { param([string]$Message) Write-Log "⚠ $Message" $yellow }
function Write-Error { param([string]$Message) Write-Log "✗ $Message" $red }
function Write-Info { param([string]$Message) Write-Log "ℹ $Message" $cyan }

# Check if running as Administrator
if (-NOT ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)) {
    Write-Error "This script must be run as Administrator!"
    exit 1
}

Write-Info "Manu Hosting Windows Node Agent Installer"
Write-Info "=========================================="
Write-Info "Install Directory: $InstallDir"
Write-Info "Node ID: $NodeId"
Write-Info "Control Plane: $ControlPlaneUrl:$ApiPort"
Write-Info ""

# Determine script directory
$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition
$AgentDir = Join-Path $ScriptDir "..\agent\src\ManuHostingAgent\bin\Release\net8.0\win-x64\publish"

# 1. Check/Install .NET 8 Runtime
if (-not $SkipDotNet) {
    Write-Info "Checking .NET 8 Runtime..."
    
    $dotnetVersion = "8.0"
    $dotnetInstalled = Get-ChildItem "HKLM:\SOFTWARE\dotnet\Setup\InstalledVersions\x64\sharedhost" -ErrorAction SilentlyContinue |
        Where-Object { $_.GetValue("Version") -like "$dotnetVersion*" }
    
    if (-not $dotnetInstalled) {
        Write-Warning ".NET 8 Runtime not found. Installing..."
        
        $dotnetUrl = "https://download.visualstudio.microsoft.com/download/pr/xxx/xxx/dotnet-runtime-8.0.x-win-x64.exe"
        $installerPath = Join-Path $env:TEMP "dotnet-runtime-8.0.exe"
        
        try {
            Invoke-WebRequest -Uri $dotnetUrl -OutFile $installerPath -UseBasicParsing
            Start-Process -FilePath $installerPath -ArgumentList "/install", "/quiet", "/norestart" -Wait
            Write-Success ".NET 8 Runtime installed"
        }
        catch {
            Write-Error "Failed to install .NET 8 Runtime: $_"
            Write-Warning "Please install .NET 8 Runtime manually from https://dotnet.microsoft.com/download/dotnet/8.0"
        }
        finally {
            if (Test-Path $installerPath) { Remove-Item $installerPath -Force }
        }
    }
    else {
        Write-Success ".NET 8 Runtime already installed"
    }
}

# 2. Check/Install Java
if (-not $SkipJava) {
    Write-Info "Checking Java Runtime..."
    
    $javaHome = [Environment]::GetEnvironmentVariable("JAVA_HOME", "Machine")
    $javaFound = $false
    
    if ($javaHome -and (Test-Path (Join-Path $javaHome "bin\java.exe"))) {
        $javaFound = $true
        Write-Success "JAVA_HOME found: $javaHome"
    }
    else {
        # Check common locations
        $javaPaths = @(
            "C:\Program Files\Java\jdk-21",
            "C:\Program Files\Java\jdk-17",
            "C:\Program Files\Eclipse Adoptium\jdk-21",
            "C:\Program Files\Eclipse Adoptium\jdk-17",
            "C:\Program Files\Microsoft\jdk-21",
            "C:\Program Files\Microsoft\jdk-17"
        )
        
        foreach ($path in $javaPaths) {
            if (Test-Path (Join-Path $path "bin\java.exe")) {
                $javaHome = $path
                $javaFound = $true
                [Environment]::SetEnvironmentVariable("JAVA_HOME", $javaHome, "Machine")
                Write-Success "Found Java at: $javaHome"
                break
            }
        }
    }
    
    if (-not $javaFound) {
        Write-Warning "Java not found. Installing Eclipse Temurin 21..."
        
        $javaUrl = "https://github.com/adoptium/temurin21-binaries/releases/download/jdk-21.0.x%2Bxx/OpenJDK21U-jdk_x64_windows_hotspot_21.0.x_xxx.msi"
        $installerPath = Join-Path $env:TEMP "temurin-jdk.msi"
        
        try {
            Invoke-WebRequest -Uri $javaUrl -OutFile $installerPath -UseBasicParsing
            Start-Process msiexec.exe -ArgumentList "/i", "`"$installerPath`"", "/quiet", "ADDLOCAL=FeatureMain", "INSTALLDIR=`"C:\Program Files\Eclipse Adoptium\jdk-21`"" -Wait
            $javaHome = "C:\Program Files\Eclipse Adoptium\jdk-21"
            [Environment]::SetEnvironmentVariable("JAVA_HOME", $javaHome, "Machine")
            Write-Success "Java 21 installed"
        }
        catch {
            Write-Error "Failed to install Java: $_"
            Write-Warning "Please install Java 21 manually from https://adoptium.net/"
        }
        finally {
            if (Test-Path $installerPath) { Remove-Item $installerPath -Force }
        }
    }
    
    # Add to PATH
    $currentPath = [Environment]::GetEnvironmentVariable("PATH", "Machine")
    $javaBin = Join-Path $javaHome "bin"
    if ($currentPath -notlike "*$javaBin*") {
        [Environment]::SetEnvironmentVariable("PATH", "$currentPath;$javaBin", "Machine")
        Write-Success "Added Java to system PATH"
    }
}

# 3. Create directory structure
Write-Info "Creating directory structure..."

$dirs = @(
    $InstallDir,
    Join-Path $InstallDir "servers",
    Join-Path $InstallDir "backups",
    Join-Path $InstallDir "temp",
    Join-Path $InstallDir "logs",
    Join-Path $InstallDir "agent"
)

foreach ($dir in $dirs) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
        Write-Success "Created: $dir"
    }
    else {
        Write-Info "Exists: $dir"
    }
}

# 4. Set ACLs for service account
Write-Info "Setting directory permissions..."

$serviceAccount = "NT SERVICE\ManuHostingAgent"
try {
    $acl = Get-Acl $InstallDir
    $rule = New-Object System.Security.AccessControl.FileSystemAccessRule($serviceAccount, "FullControl", "ContainerInherit,ObjectInherit", "None", "Allow")
    $acl.AddAccessRule($rule)
    Set-Acl $InstallDir $acl
    Write-Success "Permissions set for $serviceAccount"
}
catch {
    Write-Warning "Could not set ACLs (service may not exist yet): $_"
}

# 5. Deploy agent binaries
Write-Info "Deploying agent binaries..."

$targetDir = Join-Path $InstallDir "agent"
if (-not (Test-Path $AgentDir)) {
    Write-Warning "Agent build not found at $AgentDir"
    Write-Info "Please build the agent first with: dotnet publish -c Release -r win-x64 --self-contained true"
}
else {
    Copy-Item -Path (Join-Path $AgentDir "*") -Destination $targetDir -Force -Recurse
    Write-Success "Agent binaries deployed to $targetDir"
}

# 6. Create config.yaml
Write-Info "Creating configuration..."

$configPath = Join-Path $targetDir "config.yaml"
$config = @"
# Manu Hosting Windows Node Agent Configuration
# Generated by install.ps1 on $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")

control_plane:
  url: "$ControlPlaneUrl"
  api_port: $ApiPort
  node_id: "$NodeId"
  node_token: "$NodeToken"
  verify_ssl: true

agent:
  install_dir: "$InstallDir"
  servers_dir: "$(Join-Path $InstallDir "servers")"
  backups_dir: "$(Join-Path $InstallDir "backups")"
  temp_dir: "$(Join-Path $InstallDir "temp")"
  log_dir: "$(Join-Path $InstallDir "logs")"
  java_path: "java"
  heartbeat_interval: 30
  command_poll_interval: 5
  resource_report_interval: 60
  idle_shutdown_default: 60
  max_idle_shutdown: 900

minecraft:
  default_java_version: "21"
  default_ram: 2048
  default_cpu: 2
  default_disk: 10240
  max_players: 20
  java_versions:
    - "21"
    - "17"
    - "11"
    - "8"

process:
  shutdown_timeout: 30
  force_kill_after: 10
  jvm_args:
    - "-Xms{ram}M"
    - "-Xmx{ram}M"
    - "-XX:+UseG1GC"
    - "-XX:+ParallelRefProcEnabled"
    - "-XX:MaxGCPauseMillis=200"
    - "-XX:+UnlockExperimentalVMOptions"
    - "-XX:+DisableExplicitGC"
    - "-XX:+AlwaysPreTouch"
    - "-XX:G1NewSizePercent=30"
    - "-XX:G1MaxNewSizePercent=40"
    - "-XX:G1HeapRegionSize=8M"
    - "-XX:G1ReservePercent=20"
    - "-XX:G1HeapWastePercent=5"
    - "-XX:G1MixedGCCountTarget=4"
    - "-XX:InitiatingHeapOccupancyPercent=15"
    - "-XX:G1MixedGCLiveThresholdPercent=90"
    - "-XX:G1RSetUpdatingPauseTimePercent=5"
    - "-XX:SurvivorRatio=32"
    - "-Dusing.aikars.flags=https://mcflags.emc.gs"
    - "-Daikars.new.flags=true"

backup:
  compression: "zip"
  max_backups_per_server: 10
  exclude_patterns:
    - "*.log"
    - "*.tmp"
    - "cache/*"
    - "plugins/dynmap/*"
    - "logs/*"
    - "crash-reports/*"

network:
  port_range_start: 25565
  port_range_end: 25665
  bind_address: "0.0.0.0"

security:
  allowed_ips: []
  mutual_tls: false
"@

$config | Set-Content -Path $configPath -Encoding UTF8
Write-Success "Configuration written to $configPath"

# 7. Create Windows Service
Write-Info "Creating Windows Service..."

$serviceName = "ManuHostingAgent"
$displayName = "Manu Hosting Node Agent"
$description = "Manages Minecraft servers on this node and communicates with the Manu Hosting control plane"
$exePath = Join-Path $targetDir "ManuHostingAgent.exe"

if (Get-Service $serviceName -ErrorAction SilentlyContinue) {
    Write-Warning "Service $serviceName already exists. Stopping and removing..."
    Stop-Service $serviceName -Force -ErrorAction SilentlyContinue
    sc.exe delete $serviceName | Out-Null
    Start-Sleep -Seconds 2
}

$svcArgs = "--service"
sc.exe create $serviceName binPath= "`"$exePath`" $svcArgs" DisplayName= "$displayName" start= auto obj= "NT SERVICE\$serviceName" | Out-Null

if ($LASTEXITCODE -eq 0) {
    Write-Success "Service created: $serviceName"
    
    # Set description
    sc.exe description $serviceName "$description" | Out-Null
    
    # Set recovery actions (restart on failure)
    sc.exe failure $serviceName reset= 86400 actions= restart/60000/restart/120000/restart/300000 | Out-Null
    
    # Set service to start automatically with delayed start
    Set-ItemProperty -Path "HKLM:\SYSTEM\CurrentControlSet\Services\$serviceName" -Name "DelayedAutostart" -Value 1 -Type DWord -Force
    Write-Success "Service configured with auto-start and recovery"
}
else {
    Write-Error "Failed to create service"
    exit 1
}

# 8. Configure Firewall
Write-Info "Configuring Windows Firewall..."

$firewallRuleName = "Manu Hosting Agent - Minecraft Ports"
$existingRule = Get-NetFirewallRule -DisplayName $firewallRuleName -ErrorAction SilentlyContinue

if (-not $existingRule) {
    New-NetFirewallRule -DisplayName $firewallRuleName -Direction Inbound -Protocol TCP -LocalPort "25565-25665" -Action Allow -Profile Any -Description "Manu Hosting Minecraft server ports" | Out-Null
    Write-Success "Firewall rule created for ports 25565-25665"
}
else {
    Write-Info "Firewall rule already exists"
}

# Management API port (if needed locally)
$apiRuleName = "Manu Hosting Agent - Management API"
$existingApiRule = Get-NetFirewallRule -DisplayName $apiRuleName -ErrorAction SilentlyContinue
if (-not $existingApiRule) {
    New-NetFirewallRule -DisplayName $apiRuleName -Direction Inbound -Protocol TCP -LocalPort 8080 -Action Allow -Profile Domain,Private -Description "Manu Hosting Agent management API" | Out-Null
    Write-Success "Firewall rule created for management API (port 8080)"
}

# 9. Start the service
Write-Info "Starting service..."

try {
    Start-Service $serviceName -ErrorAction Stop
    Start-Sleep -Seconds 3
    
    $status = (Get-Service $serviceName).Status
    if ($status -eq "Running") {
        Write-Success "Service started successfully"
    }
    else {
        Write-Warning "Service status: $status"
        Write-Info "Check logs at: $(Join-Path $InstallDir "logs")"
    }
}
catch {
    Write-Error "Failed to start service: $_"
    Write-Info "Check Event Viewer > Windows Logs > Application for details"
}

Write-Info ""
Write-Success "=========================================="
Write-Success "Manu Hosting Node Agent installation complete!"
Write-Success "=========================================="
Write-Info ""
Write-Info "Next steps:"
Write-Info "1. Verify the agent connects to the control plane"
Write-Info "2. Check logs at: $(Join-Path $InstallDir "logs")"
Write-Info "3. Service name: $serviceName"
Write-Info "4. Config file: $configPath"
Write-Info ""
Write-Info "To uninstall, run: .\uninstall.ps1"
