package com.manuhosting.bridge;

import com.manuhosting.bridge.api.ApiClient;
import com.manuhosting.bridge.config.BridgeConfig;
import com.manuhosting.bridge.listener.PlayerListener;
import com.manuhosting.bridge.listener.InventoryListener;
import com.manuhosting.bridge.listener.AntiCheatListener;
import com.manuhosting.bridge.command.BridgeCommand;
import org.bukkit.plugin.java.JavaPlugin;
import org.bukkit.Bukkit;
import org.bukkit.scheduler.BukkitRunnable;

public class ManuHostingBridge extends JavaPlugin {

    private static ManuHostingBridge instance;
    private BridgeConfig config;
    private ApiClient apiClient;
    private String serverUuid;
    private boolean bridgeEnabled = false;

    @Override
    public void onEnable() {
        instance = this;
        
        // Create data folder if not exists
        if (!getDataFolder().exists()) {
            getDataFolder().mkdirs();
        }
        
        // Load configuration
        saveDefaultConfig();
        reloadConfig();
        this.config = new BridgeConfig(this);
        
        // Get server UUID from config or generate
        this.serverUuid = config.getServerUuid();
        if (serverUuid == null || serverUuid.isEmpty()) {
            serverUuid = java.util.UUID.randomUUID().toString();
            config.setServerUuid(serverUuid);
            config.save();
            getLogger().info("Generated new server UUID: " + serverUuid);
        }
        
        // Initialize API client
        this.apiClient = new ApiClient(config);
        
        // Register listeners
        registerListeners();
        
        // Register commands
        registerCommands();
        
        // Register server with platform
        registerServerWithPlatform();
        
        // Start heartbeat task
        startHeartbeat();
        
        getLogger().info("Manu Hosting Bridge enabled for server: " + serverUuid);
        getLogger().info("Platform URL: " + config.getPlatformUrl());
    }

    @Override
    public void onDisable() {
        // Notify platform server is stopping
        if (bridgeEnabled && apiClient != null) {
            apiClient.sendServerStatus("stopping", 0, 0, 0, 0);
        }
        getLogger().info("Manu Hosting Bridge disabled");
    }

    private void registerListeners() {
        // Player join/quit events
        getServer().getPluginManager().registerEvents(new PlayerListener(this), this);
        
        // Inventory events
        getServer().getPluginManager().registerEvents(new InventoryListener(this), this);
        
        // Anti-cheat events
        getServer().getPluginManager().registerEvents(new AntiCheatListener(this), this);
    }

    private void registerCommands() {
        getCommand("manubridge").setExecutor(new BridgeCommand(this));
    }

    private void registerServerWithPlatform() {
        new BukkitRunnable() {
            @Override
            public void run() {
                try {
                    boolean success = apiClient.registerServer(
                        serverUuid,
                        getServer().getName(),
                        getServer().getVersion(),
                        getServer().getBukkitVersion(),
                        config.getNodeId()
                    );
                    if (success) {
                        bridgeEnabled = true;
                        getLogger().info("Successfully registered with platform");
                    } else {
                        getLogger().warning("Failed to register with platform, will retry...");
                    }
                } catch (Exception e) {
                    getLogger().warning("Error registering with platform: " + e.getMessage());
                }
            }
        }.runTaskAsynchronously(this);
    }

    private void startHeartbeat() {
        new BukkitRunnable() {
            @Override
            public void run() {
                if (!bridgeEnabled || apiClient == null) return;
                
                try {
                    int playersOnline = Bukkit.getOnlinePlayers().size();
                    int playersMax = Bukkit.getMaxPlayers();
                    
                    // Get approximate CPU/RAM usage
                    Runtime runtime = Runtime.getRuntime();
                    long usedMemory = runtime.totalMemory() - runtime.freeMemory();
                    long maxMemory = runtime.maxMemory();
                    int ramUsage = (int) ((usedMemory * 100) / maxMemory);
                    
                    // CPU usage is harder to get in Java, use a simple approximation
                    int cpuUsage = Math.min(100, playersOnline * 5);
                    
                    apiClient.sendServerStatus("online", playersOnline, playersMax, cpuUsage, ramUsage);
                } catch (Exception e) {
                    getLogger().warning("Heartbeat error: " + e.getMessage());
                }
            }
        }.runTaskTimerAsynchronously(this, 20 * 30, 20 * 30); // Every 30 seconds
    }

    public static ManuHostingBridge getInstance() {
        return instance;
    }

    public BridgeConfig getBridgeConfig() {
        return config;
    }

    public ApiClient getApiClient() {
        return apiClient;
    }

    public String getServerUuid() {
        return serverUuid;
    }

    public boolean isBridgeEnabled() {
        return bridgeEnabled;
    }

    public void setBridgeEnabled(boolean enabled) {
        this.bridgeEnabled = enabled;
    }
}
