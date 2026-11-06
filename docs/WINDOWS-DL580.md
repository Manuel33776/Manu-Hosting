# MANU HOSTING - WINDOWS DL580 SETUP

Complete setup guide for the HP ProLiant DL580 Windows node server.

---

## System Requirements

### Hardware (HP ProLiant DL580)
- **Model**: HP ProLiant DL580 Gen9/Gen10 (or compatible)
- **CPU**: 4x Intel Xeon E7-xxxx (minimum 16 cores total, 32+ recommended)
- **RAM**: 32 GB minimum, 64 GB+ recommended (DDR4 ECC)
- **Storage**: 500 GB+ NVMe/SSD (RAID 1/10 recommended for OS, separate for game data)
- **Network**: 1 Gbps minimum, 10 Gbps recommended
- **Power**: Redundant PSUs

### Software
- **OS**: Windows Server 2019/2022 Standard/Datacenter OR Windows 10/11 Pro/Enterprise
- **.NET**: .NET 8 Runtime (installed by agent installer)
- **Java**: Eclipse Temurin 21 (installed by agent installer)
- **PowerShell**: 5.1+ (built-in)

### Network
- **Outbound**: HTTPS (443) to Debian control plane
- **Inbound**: Minecraft ports 25565-25665 (TCP)
- **Management**: RDP (3389) for administration
- **Internal**: Agent communicates outbound only (no inbound ports required for agent)

---

## Windows Installation

### 1. Install Windows

1. Download Windows Server 2022 ISO from Microsoft Evaluation Center
2. Boot from USB/install media
3. Install Windows Server 2022 Standard/Datacenter (Desktop Experience)
4. During setup:
   - Choose "Custom: Install Windows only"
   - Create partitions: 100 GB for OS, rest for data (D:)
   - Set computer name: `DL580-MANU`
   - Set static IP or DHCP reservation

### 2. Post-Install Configuration

```powershell
# Run as Administrator

# Set execution policy for scripts
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Force

# Disable IE Enhanced Security (for downloads)
Set-ItemProperty -Path "HKLM:\SOFTWARE\Microsoft\Active Setup\Installed Components\{A509B1A7-37EF-4b3f-8CFC-4F3A74704073}" -Name "IsInstalled" -Value 0
Set-ItemProperty -Path "HKLM:\SOFTWARE\Microsoft\Active Setup\Installed Components\{A509B1A8-37EF-4b3f-8CFC-4F3A74704073}" -Name "IsInstalled" -Value 0

# Enable Remote Desktop (for management)
Set-ItemProperty -Path "HKLM:\System\CurrentControlSet\Control\Terminal Server" -Name "fDenyTSConnections" -Value 0
Enable-NetFirewallRule -DisplayGroup "Remote Desktop"

# Set power plan to High Performance
powercfg -setactive SCHEME_MIN

# Disable Windows Update automatic restart (we manage updates)
Set-ItemProperty -Path "HKLM:\SOFTWARE\Policies\Microsoft\Windows\WindowsUpdate\AU" -Name "NoAutoRebootWithLoggedOnUsers" -Value 1 -Force
```

### 3. Create Data Drive

If you have a separate drive for game data (D:):

```powershell
# Initialize and format data drive (adjust disk number)
Initialize-Disk -Number 1 -PartitionStyle GPT
New-Partition -DiskNumber 1 -UseMaximumSize -DriveLetter D
Format-Volume -DriveLetter D -FileSystem NTFS -NewFileSystemLabel "ManuHostingData" -Force

# Verify
Get-Volume -DriveLetter D
```

---

## Prerequisites Installation

The agent installer (`install.ps1`) will automatically install:
- .NET 8 Runtime
- Eclipse Temurin Java 21

But you can pre-install them manually:

### .NET 8 Runtime

```powershell
# Download and install
$dotnetUrl = "https://download.visualstudio.microsoft.com/download/pr/xxx/dotnet-runtime-8.0.x-win-x64.exe"
$installer = "$env:TEMP\dotnet-runtime-8.0.exe"
Invoke-WebRequest -Uri $dotnetUrl -OutFile $installer
Start-Process -FilePath $installer -ArgumentList "/install", "/quiet", "/norestart" -Wait
Remove-Item $installer

# Verify
dotnet --version
```

### Java 21 (Eclipse Temurin)

```powershell
# Download and install
$javaUrl = "https://github.com/adoptium/temurin21-binaries/releases/download/jdk-21.0.x%2Bxx/OpenJDK21U-jdk_x64_windows_hotspot_21.0.x_xxx.msi"
$installer = "$env:TEMP\temurin-jdk.msi"
Invoke-WebRequest -Uri $javaUrl -OutFile $installer
Start-Process msiexec.exe -ArgumentList "/i", "`"$installer`"", "/quiet", "ADDLOCAL=FeatureMain" -Wait
Remove-Item $installer

# Set JAVA_HOME
$javaHome = "C:\Program Files\Eclipse Adoptium\jdk-21"
[Environment]::SetEnvironmentVariable("JAVA_HOME", $javaHome, "Machine")
[Environment]::SetEnvironmentVariable("PATH", [Environment]::GetEnvironmentVariable("PATH", "Machine") + ";$javaHome\bin", "Machine")

# Verify
java -version
```

---

## Agent Deployment

### 1. Build Agent (on Build Machine)

```powershell
# On a Windows machine with .NET 8 SDK installed
cd C:\path\to\Manu-Hosting\windows-node\agent\src\ManuHostingAgent

# Publish self-contained
dotnet publish -c Release -r win-x64 --self-contained true -p:PublishSingleFile=true -o ..\..\..\..\publish

# Verify output
ls ..\..\..\..\publish
# Should contain: ManuHostingAgent.exe, config.yaml, appsettings.json, etc.
```

### 2. Copy to DL580

Copy the entire `publish` folder to the DL580:
- Via USB drive
- Via network share (SMB)
- Via RDP file copy
- Via WinSCP/SCP

Example destination on DL580: `C:\ManuHostingAgent\publish`

### 3. Run Installer

```powershell
# On DL580, run PowerShell as Administrator
cd C:\ManuHostingAgent\publish\installer  # or wherever you copied it

# Generate a secure token (run once, save securely)
# Example: [System.Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Maximum 256 }))

# Run installer with your values
.\install.ps1 -NodeToken "YOUR_GENERATED_SECURE_TOKEN" -ControlPlaneUrl "https://your-domain.de"
```

### 4. Installer Parameters

| Parameter | Required | Default | Description |
|-----------|----------|---------|-------------|
| `-InstallDir` | No | `D:\ManuHosting` | Base installation directory |
| `-NodeId` | No | `dl580-node-01` | Unique node identifier |
| `-NodeToken` | **Yes** | - | Secure authentication token |
| `-ControlPlaneUrl` | No | `https://manu-hosting.de` | Debian control plane URL |
| `-ApiPort` | No | `8443` | Control plane API port |
| `-SkipDotNet` | No | - | Skip .NET 8 installation |
| `-SkipJava` | No | - | Skip Java installation |
| `-Force` | No | - | Force reinstall |

### 5. What the Installer Does

1. **Checks Administrator rights**
2. **Installs .NET 8 Runtime** (if not present)
3. **Installs Java 21** (if not present, sets JAVA_HOME)
4. **Creates directory structure:**
   - `D:\ManuHosting\` (base)
   - `D:\ManuHosting\servers\` (Minecraft servers)
   - `D:\ManuHosting\backups\` (backup storage)
   - `D:\ManuHosting\temp\` (temporary files)
   - `D:\ManuHosting\logs\` (agent logs)
   - `D:\ManuHosting\agent\` (agent binaries)
5. **Sets ACLs** for `NT SERVICE\ManuHostingAgent` service account
6. **Deploys agent binaries** to `D:\ManuHosting\agent\`
7. **Generates config.yaml** with your settings
8. **Creates Windows Service:**
   - Name: `ManuHostingAgent`
   - Display: `Manu Hosting Node Agent`
   - Startup: Automatic (delayed)
   - Recovery: Restart on failure (1min, 2min, 5min)
   - Account: `NT SERVICE\ManuHostingAgent` (virtual account)
9. **Configures Windows Firewall:**
   - Inbound: TCP 25565-25665 (Minecraft)
   - Inbound: TCP 8080 (Management API, domain/private only)
10. **Starts the service**

---

## Configuration

### config.yaml Location

`D:\ManuHosting\agent\config.yaml`

### Key Configuration Sections

```yaml
control_plane:
  url: "https://your-domain.de"      # Control plane URL
  api_port: 8443                      # API port
  node_id: "dl580-node-01"            # Must match Owner Dashboard
  node_token: "YOUR_TOKEN"            # Must match Owner Dashboard
  verify_ssl: true                    # Verify SSL cert

agent:
  install_dir: "D:\ManuHosting"
  servers_dir: "D:\ManuHosting\servers"
  backups_dir: "D:\ManuHosting\backups"
  temp_dir: "D:\ManuHosting\temp"
  log_dir: "D:\ManuHosting\logs"
  java_path: "java"                   # Uses PATH
  heartbeat_interval: 30              # Seconds
  command_poll_interval: 5            # Seconds
  resource_report_interval: 60        # Seconds
  idle_shutdown_default: 60           # Seconds (0 = disabled)
  max_idle_shutdown: 900              # Max allowed (seconds)

minecraft:
  default_java_version: "21"
  default_ram: 2048
  default_cpu: 2
  default_disk: 10240
  max_players: 20
  java_versions: ["21", "17", "11", "8"]

process:
  shutdown_timeout: 30
  force_kill_after: 10
  jvm_args: [ ... ]  # Aikar flags included

backup:
  compression: "zip"
  max_backups_per_server: 10
  exclude_patterns: ["*.log", "*.tmp", "cache/*", "plugins/dynmap/*"]

network:
  port_range_start: 25565
  port_range_end: 25665
  bind_address: "0.0.0.0"

security:
  allowed_ips: []
  mutual_tls: false
```

### Modifying Configuration

1. Edit `D:\ManuHosting\agent\config.yaml`
2. Restart service: `Restart-Service ManuHostingAgent`

---

## Verification

### 1. Check Service Status

```powershell
Get-Service ManuHostingAgent

# Should show: Status = Running
```

### 2. Check Logs

```powershell
# Agent logs
Get-Content "D:\ManuHosting\logs\*.log" -Tail 100

# Windows Event Log
Get-WinEvent -LogName Application -ProviderName "ManuHostingAgent" -MaxEvents 50
```

### 3. Verify Control Plane Connection

Look for these log messages:
```
[INF] Successfully registered with control plane
[INF] Heartbeat sent successfully
```

### 4. Test Node API (from DL580)

```powershell
# Test local management API (if enabled)
Invoke-WebRequest -Uri "http://localhost:8080/health" -UseBasicParsing
```

---

## Owner Dashboard Configuration

After agent is running:

1. Login to Owner Dashboard: `https://your-domain.de/owner`
2. Go to **Nodes** → **Add Node**
3. Fill in:
   - **Name**: `DL580 Primary` (or your preferred name)
   - **Node ID**: `dl580-node-01` (must match config.yaml)
   - **Token**: Same token used in install.ps1
   - **Host**: DL580 IP address or hostname
   - **API Port**: `8443`
4. Save
5. Node should show **"Online"** within 30 seconds (first heartbeat)

---

## Minecraft Server Deployment

### 1. Create Hosting Packages

In Owner Dashboard → **Packages** → **Create Package**:
- Define RAM, CPU, Disk limits
- Set supported software (Paper, Purpur, etc.)
- Set idle shutdown default

### 2. Customer Creates Server

Customer logs in → **Create Server** → Selects package → Server provisions automatically

### 3. Bridge Plugin

Each Minecraft server needs the Bridge plugin:
1. Build: `cd minecraft-bridge/paper && mvn clean package`
2. Copy `target/manu-hosting-bridge-1.0.0.jar` to server's `plugins/` folder
3. Configure `plugins/ManuHostingBridge/config.yml`
4. Restart server

---

## Maintenance

### Update Agent

```powershell
# 1. Build new version on build machine
# 2. Copy to DL580
# 3. Stop service
Stop-Service ManuHostingAgent

# 4. Replace binaries in D:\ManuHosting\agent\
# 5. Start service
Start-Service ManuHostingAgent
```

### Windows Updates

```powershell
# Check for updates
Install-Module -Name PSWindowsUpdate -Force
Get-WindowsUpdate

# Install updates (schedule during maintenance window)
Install-WindowsUpdate -AcceptAll -AutoReboot
```

### Java Updates

```powershell
# Download new Temurin version
# Stop all Minecraft servers first!
# Uninstall old: msiexec /x {product_code} /quiet
# Install new MSI
# Update JAVA_HOME if path changed
# Restart agent service
```

### Disk Space Monitoring

```powershell
# Check disk space
Get-Volume -DriveLetter D | Select-Object DriveLetter, @{Name="FreeGB";Expression={[math]::Round($_.SizeRemaining/1GB,2)}}, @{Name="TotalGB";Expression={[math]::Round($_.Size/1GB,2)}}

# Clean old backups (agent does this automatically)
# Check temp directory
Get-ChildItem "D:\ManuHosting\temp" -Recurse | Where-Object { $_.LastWriteTime -lt (Get-Date).AddDays(-7) } | Remove-Item -Force -Recurse
```

---

## Troubleshooting

### Service Won't Start

```powershell
# Check event logs
Get-WinEvent -LogName Application -FilterXPath "*[System[Provider[@Name='ManuHostingAgent']]]" -MaxEvents 20

# Check service dependencies
sc.exe qc ManuHostingAgent

# Run manually for debugging
cd D:\ManuHosting\agent
.\ManuHostingAgent.exe
# Press Ctrl+C to stop
```

### Node Shows Offline in Dashboard

1. Check service: `Get-Service ManuHostingAgent`
2. Check logs for connection errors
3. Verify firewall allows outbound 443 to Debian
4. Verify NodeId and Token match exactly
5. Check Debian API port 8443 accessible: `Test-NetConnection -ComputerName your-domain.de -Port 8443`
6. Check DNS resolution: `Resolve-DnsName your-domain.de`

### Minecraft Server Won't Start

1. Check Java: `java -version` (should be 21)
2. Check server directory permissions
3. Check agent logs for download errors
4. Verify server JAR exists in server directory
5. Check port not already in use: `netstat -ano | findstr :25565`

### High CPU/RAM Usage

1. Check server count vs. hardware limits
2. Review JVM arguments in config.yaml
3. Consider limiting servers per node
4. Check for runaway processes: `Get-Process java | Sort-Object CPU -Descending | Select-Object -First 10`

### Backup Failures

1. Check disk space on D:
2. Check backup directory permissions
3. Check agent logs for SharpCompress errors
4. Verify exclude patterns not too broad

---

## Security

### Firewall Rules

```powershell
# List current rules
Get-NetFirewallRule -DisplayName "Manu Hosting*" | Format-Table DisplayName, Enabled, Direction, Action, LocalPort

# Restrict management API to specific IPs (optional)
Set-NetFirewallRule -DisplayName "Manu Hosting Agent - Management API" -RemoteAddress "10.0.0.0/8,192.168.0.0/16"
```

### Service Account

The agent runs as `NT SERVICE\ManuHostingAgent` (Virtual Service Account):
- No password to manage
- Automatic SPN management
- Limited privileges
- Access controlled via ACLs on `D:\ManuHosting`

### Audit Policy

```powershell
# Enable auditing for service changes
auditpol /set /subcategory:"Service Installation" /success:enable /failure:enable
auditpol /set /subcategory:"Process Creation" /success:enable /failure:enable
```

---

## Monitoring

### Key Metrics to Monitor

| Metric | Warning | Critical |
|--------|---------|----------|
| CPU Usage | > 70% | > 90% |
| RAM Usage | > 80% | > 95% |
| Disk Free | < 20% | < 10% |
| Service Status | Stopped | Stopped |
| Heartbeat Age | > 60s | > 120s |
| Server Count | > 80% capacity | At capacity |

### PowerShell Monitoring Script

```powershell
# Save as monitor.ps1 and run via Task Scheduler
$cpu = (Get-Counter "\Processor(_Total)\% Processor Time").CounterSamples.CookedValue
$ram = (Get-CimInstance Win32_OperatingSystem).FreePhysicalMemory / 1MB
$disk = (Get-Volume -DriveLetter D).SizeRemaining / 1GB
$service = (Get-Service ManuHostingAgent).Status

Write-Host "CPU: $([math]::Round($cpu,1))% | RAM Free: $([math]::Round($ram/1024,1)) GB | Disk Free: $([math]::Round($disk,1)) GB | Service: $service"
```

---

## Uninstall

```powershell
# Run as Administrator
cd C:\ManuHostingAgent\publish\installer
.\uninstall.ps1 [-RemoveData] [-Force]

# -RemoveData: Also deletes servers, backups, logs
# -Force: No confirmation prompt
```

---

## Support

For issues, check:
- Agent logs: `D:\ManuHosting\logs\`
- Windows Event Viewer: Application log (source: ManuHostingAgent)
- Windows Firewall: `wf.msc`
- Service: `services.msc` → ManuHostingAgent

Create a ticket in the Owner Dashboard → Support for platform issues.
