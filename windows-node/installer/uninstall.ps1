<#
.SYNOPSIS
    Manu Hosting Windows Node Agent Uninstaller
    Removes the agent service and cleans up installation

.DESCRIPTION
    This script uninstalls the Manu Hosting Windows Node Agent including:
    - Windows Service removal
    - Firewall rules cleanup
    - Directory cleanup (optional)
    - Environment variable cleanup

.PARAMETER InstallDir
    Installation directory (default: D:\ManuHosting)

.PARAMETER RemoveData
    Also remove server data, backups, and logs (default: false)

.PARAMETER Force
    Force removal without confirmation
#>

param(
    [Parameter(Mandatory=$false)]
    [string]$InstallDir = "D:\ManuHosting",
    
    [Parameter(Mandatory=$false)]
    [switch]$RemoveData,
    
    [Parameter(Mandatory=$false)]
    [switch]$Force
)

$ErrorActionPreference = "Stop"

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

Write-Info "Manu Hosting Windows Node Agent Uninstaller"
Write-Info "============================================"
Write-Info ""

$serviceName = "ManuHostingAgent"

# Confirmation
if (-not $Force) {
    $confirm = Read-Host "This will uninstall the Manu Hosting Node Agent. Continue? (y/N)"
    if ($confirm -notlike "y*") {
        Write-Info "Uninstall cancelled"
        exit 0
    }
}

# 1. Stop and remove service
Write-Info "Removing Windows Service..."

if (Get-Service $serviceName -ErrorAction SilentlyContinue) {
    try {
        Stop-Service $serviceName -Force -ErrorAction Stop
        Write-Success "Service stopped"
    }
    catch {
        Write-Warning "Could not stop service: $_"
    }

    try {
        sc.exe delete $serviceName | Out-Null
        Write-Success "Service deleted"
    }
    catch {
        Write-Error "Failed to delete service: $_"
    }
}
else {
    Write-Info "Service not found"
}

# 2. Remove firewall rules
Write-Info "Removing firewall rules..."

$rules = @(
    "Manu Hosting Agent - Minecraft Ports",
    "Manu Hosting Agent - Management API"
)

foreach ($rule in $rules) {
    try {
        Remove-NetFirewallRule -DisplayName $rule -ErrorAction Stop
        Write-Success "Removed firewall rule: $rule"
    }
    catch {
        Write-Warning "Could not remove firewall rule $rule: $_"
    }
}

# 3. Remove directories
if ($RemoveData -or $Force) {
    Write-Info "Removing installation directory..."
    
    if (Test-Path $InstallDir) {
        try {
            Remove-Item -Path $InstallDir -Recurse -Force -ErrorAction Stop
            Write-Success "Removed directory: $InstallDir"
        }
        catch {
            Write-Error "Failed to remove directory: $_"
        }
    }
}
else {
    Write-Info "Keeping data directories (servers, backups, logs)"
    Write-Info "Use -RemoveData to remove all data"
    
    # Only remove agent binaries
    $agentDir = Join-Path $InstallDir "agent"
    if (Test-Path $agentDir) {
        try {
            Remove-Item -Path $agentDir -Recurse -Force
            Write-Success "Removed agent binaries"
        }
        catch {
            Write-Warning "Could not remove agent binaries: $_"
        }
    }
}

# 4. Clean up environment variables (optional)
Write-Info "Cleaning up..."

# Note: We don"t remove JAVA_HOME or PATH modifications as they may be used by other applications

Write-Info ""
Write-Success "============================================"
Write-Success "Manu Hosting Node Agent uninstalled!"
Write-Success "============================================"
Write-Info ""
if (-not $RemoveData) {
    Write-Info "Data preserved at: $InstallDir"
    Write-Info "To completely remove, run with -RemoveData"
}
