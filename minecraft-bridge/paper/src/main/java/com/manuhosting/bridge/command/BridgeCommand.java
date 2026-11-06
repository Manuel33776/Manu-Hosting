package com.manuhosting.bridge.command;

import com.manuhosting.bridge.ManuHostingBridge;
import com.manuhosting.bridge.api.ApiClient;
import com.manuhosting.bridge.config.BridgeConfig;
import org.bukkit.Bukkit;
import org.bukkit.ChatColor;
import org.bukkit.command.Command;
import org.bukkit.command.CommandExecutor;
import org.bukkit.command.CommandSender;
import org.bukkit.entity.Player;
import org.bukkit.scheduler.BukkitRunnable;

public class BridgeCommand implements CommandExecutor {

    private final ManuHostingBridge plugin;

    public BridgeCommand(ManuHostingBridge plugin) {
        this.plugin = plugin;
    }

    @Override
    public boolean onCommand(CommandSender sender, Command command, String label, String[] args) {
        if (!(sender instanceof Player)) {
            sender.sendMessage(ChatColor.RED + "This command can only be executed by a player.");
            return true;
        }

        Player player = (Player) sender;

        if (!player.hasPermission("manubridge.admin")) {
            player.sendMessage(ChatColor.RED + "You do not have permission to use this command.");
            return true;
        }

        if (args.length == 0) {
            sendHelp(player);
            return true;
        }

        String subCommand = args[0].toLowerCase();

        switch (subCommand) {
            case "reload" -> handleReload(player);
            case "status" -> handleStatus(player);
            case "test" -> handleTest(player);
            default -> sendHelp(player);
        }

        return true;
    }

    private void sendHelp(Player player) {
        player.sendMessage(ChatColor.AQUA + "=== " + ChatColor.YELLOW + "Manu Hosting Bridge" + ChatColor.AQUA + " ===");
        player.sendMessage(ChatColor.GRAY + "/manubridge reload " + ChatColor.WHITE + "- Reload bridge configuration");
        player.sendMessage(ChatColor.GRAY + "/manubridge status " + ChatColor.WHITE + "- Show bridge connection status");
        player.sendMessage(ChatColor.GRAY + "/manubridge test " + ChatColor.WHITE + "- Test connection to platform");
    }

    private void handleReload(Player player) {
        player.sendMessage(ChatColor.YELLOW + "Reloading bridge configuration...");

        new BukkitRunnable() {
            @Override
            public void run() {
                try {
                    BridgeConfig oldConfig = plugin.getBridgeConfig();
                    String oldPlatformUrl = oldConfig.getPlatformUrl();
                    String oldBridgeSecret = oldConfig.getBridgeSecret();
                    String oldNodeId = oldConfig.getNodeId();

                    plugin.reloadConfig();
                    plugin.getBridgeConfig().reload();

                    BridgeConfig newConfig = plugin.getBridgeConfig();
                    boolean urlChanged = !oldPlatformUrl.equals(newConfig.getPlatformUrl());
                    boolean secretChanged = !oldBridgeSecret.equals(newConfig.getBridgeSecret());
                    boolean nodeChanged = !oldNodeId.equals(newConfig.getNodeId());

                    if (urlChanged || secretChanged || nodeChanged) {
                        plugin.getLogger().info("Critical config changed, re-initializing API client...");
                        // Note: Full re-initialization would require plugin restart
                        player.sendMessage(ChatColor.YELLOW + "Configuration reloaded. Note: Platform URL/Secret/Node ID changes require plugin restart.");
                    } else {
                        player.sendMessage(ChatColor.GREEN + "Configuration reloaded successfully!");
                    }

                    if (plugin.getBridgeConfig().isDebugMode()) {
                        plugin.getLogger().info("Bridge config reloaded by " + player.getName());
                    }
                } catch (Exception e) {
                    player.sendMessage(ChatColor.RED + "Error reloading config: " + e.getMessage());
                    plugin.getLogger().severe("Config reload error: " + e.getMessage());
                }
            }
        }.runTaskAsynchronously(plugin);
    }

    private void handleStatus(Player player) {
        BridgeConfig config = plugin.getBridgeConfig();
        ApiClient apiClient = plugin.getApiClient();
        boolean enabled = plugin.isBridgeEnabled();

        player.sendMessage(ChatColor.AQUA + "=== " + ChatColor.YELLOW + "Bridge Status" + ChatColor.AQUA + " ===");
        player.sendMessage(ChatColor.GRAY + "Server UUID: " + ChatColor.WHITE + plugin.getServerUuid());
        player.sendMessage(ChatColor.GRAY + "Platform URL: " + ChatColor.WHITE + config.getPlatformUrl());
        player.sendMessage(ChatColor.GRAY + "Node ID: " + ChatColor.WHITE + config.getNodeId());
        player.sendMessage(ChatColor.GRAY + "Bridge Enabled: " + (enabled ? ChatColor.GREEN + "Yes" : ChatColor.RED + "No"));
        player.sendMessage(ChatColor.GRAY + "Debug Mode: " + (config.isDebugMode() ? ChatColor.GREEN + "On" : ChatColor.GRAY + "Off"));
        player.sendMessage(ChatColor.GRAY + "Anti-Cheat: " + (config.isAntiCheatEnabled() ? ChatColor.GREEN + "Enabled" : ChatColor.RED + "Disabled"));
        player.sendMessage(ChatColor.GRAY + "Heartbeat Interval: " + ChatColor.WHITE + config.getHeartbeatInterval() + "s");
        player.sendMessage(ChatColor.GRAY + "Inventory Update Interval: " + ChatColor.WHITE + config.getInventoryUpdateInterval() + "s");

        if (apiClient != null) {
            new BukkitRunnable() {
                @Override
                public void run() {
                    try {
                        boolean connected = apiClient.testConnection();
                        player.sendMessage(ChatColor.GRAY + "Platform Connection: " + (connected ? ChatColor.GREEN + "Connected" : ChatColor.RED + "Failed"));
                    } catch (Exception e) {
                        player.sendMessage(ChatColor.GRAY + "Platform Connection: " + ChatColor.RED + "Error (" + e.getMessage() + ")");
                    }
                }
            }.runTaskAsynchronously(plugin);
        } else {
            player.sendMessage(ChatColor.GRAY + "Platform Connection: " + ChatColor.RED + "API Client not initialized");
        }

        // Online players
        int online = Bukkit.getOnlinePlayers().size();
        int max = Bukkit.getMaxPlayers();
        player.sendMessage(ChatColor.GRAY + "Players Online: " + ChatColor.WHITE + online + "/" + max);

        // Memory usage
        Runtime runtime = Runtime.getRuntime();
        long used = runtime.totalMemory() - runtime.freeMemory();
        long maxMem = runtime.maxMemory();
        player.sendMessage(ChatColor.GRAY + "Memory Usage: " + ChatColor.WHITE + formatBytes(used) + " / " + formatBytes(maxMem));
    }

    private void handleTest(Player player) {
        player.sendMessage(ChatColor.YELLOW + "Testing connection to platform...");

        ApiClient apiClient = plugin.getApiClient();
        if (apiClient == null) {
            player.sendMessage(ChatColor.RED + "API Client not initialized!");
            return;
        }

        new BukkitRunnable() {
            @Override
            public void run() {
                try {
                    boolean success = apiClient.testConnection();
                    if (success) {
                        player.sendMessage(ChatColor.GREEN + "Connection test successful!");
                        plugin.getLogger().info("Connection test passed by " + player.getName());
                    } else {
                        player.sendMessage(ChatColor.RED + "Connection test failed! Check logs for details.");
                        plugin.getLogger().warning("Connection test failed for " + player.getName());
                    }
                } catch (Exception e) {
                    player.sendMessage(ChatColor.RED + "Connection test error: " + e.getMessage());
                    plugin.getLogger().severe("Connection test error: " + e.getMessage());
                }
            }
        }.runTaskAsynchronously(plugin);
    }

    private String formatBytes(long bytes) {
        if (bytes < 1024) return bytes + " B";
        int exp = (int) (Math.log(bytes) / Math.log(1024));
        String pre = "KMGTPE".charAt(exp - 1) + "";
        return String.format("%.1f %sB", bytes / Math.pow(1024, exp), pre);
    }
}

