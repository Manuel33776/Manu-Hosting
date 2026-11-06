package com.manuhosting.bridge.listener;

import com.manuhosting.bridge.ManuHostingBridge;
import com.manuhosting.bridge.api.ApiClient;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.EventPriority;
import org.bukkit.event.Listener;
import org.bukkit.event.player.PlayerJoinEvent;
import org.bukkit.event.player.PlayerQuitEvent;
import org.bukkit.event.player.PlayerKickEvent;

public class PlayerListener implements Listener {

    private final ManuHostingBridge plugin;
    private final ApiClient apiClient;

    public PlayerListener(ManuHostingBridge plugin) {
        this.plugin = plugin;
        this.apiClient = plugin.getApiClient();
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onPlayerJoin(PlayerJoinEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        
        Player player = event.getPlayer();
        int playersOnline = plugin.getServer().getOnlinePlayers().size();
        
        // Run async to not block the main thread
        plugin.getServer().getScheduler().runTaskAsynchronously(plugin, () -> {
            try {
                apiClient.sendPlayerJoin(player.getUniqueId().toString(), player.getName(), playersOnline);
                if (plugin.getBridgeConfig().isDebugMode()) {
                    plugin.getLogger().info("Player joined: " + player.getName() + " (online: " + playersOnline + ")");
                }
            } catch (Exception e) {
                plugin.getLogger().warning("Error sending player join: " + e.getMessage());
            }
        });
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onPlayerQuit(PlayerQuitEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        
        Player player = event.getPlayer();
        // Player is already removed from online players at this point
        int playersOnline = plugin.getServer().getOnlinePlayers().size();
        
        plugin.getServer().getScheduler().runTaskAsynchronously(plugin, () -> {
            try {
                apiClient.sendPlayerQuit(player.getUniqueId().toString(), player.getName(), playersOnline);
                if (plugin.getBridgeConfig().isDebugMode()) {
                    plugin.getLogger().info("Player quit: " + player.getName() + " (online: " + playersOnline + ")");
                }
            } catch (Exception e) {
                plugin.getLogger().warning("Error sending player quit: " + e.getMessage());
            }
        });
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onPlayerKick(PlayerKickEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        
        Player player = event.getPlayer();
        int playersOnline = plugin.getServer().getOnlinePlayers().size() - 1; // Player will be removed
        
        plugin.getServer().getScheduler().runTaskAsynchronously(plugin, () -> {
            try {
                apiClient.sendPlayerQuit(player.getUniqueId().toString(), player.getName(), playersOnline);
            } catch (Exception e) {
                plugin.getLogger().warning("Error sending player kick: " + e.getMessage());
            }
        });
    }
}
