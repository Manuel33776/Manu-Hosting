package com.manuhosting.bridge.config;

import com.manuhosting.bridge.ManuHostingBridge;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.configuration.file.YamlConfiguration;

import java.io.File;
import java.io.IOException;

public class BridgeConfig {

    private final ManuHostingBridge plugin;
    private FileConfiguration config;
    private File configFile;

    private String platformUrl;
    private String bridgeSecret;
    private String nodeId;
    private String serverUuid;
    private boolean enabled;
    private int heartbeatInterval;
    private int inventoryUpdateInterval;
    private boolean antiCheatEnabled;
    private boolean debugMode;

    public BridgeConfig(ManuHostingBridge plugin) {
        this.plugin = plugin;
        loadConfig();
    }

    private void loadConfig() {
        configFile = new File(plugin.getDataFolder(), "config.yml");
        if (!configFile.exists()) {
            plugin.saveDefaultConfig();
        }
        config = YamlConfiguration.loadConfiguration(configFile);
        
        this.platformUrl = config.getString("platform.url", "https://panel.manu-hosting.de");
        this.bridgeSecret = config.getString("platform.bridge-secret", "");
        this.nodeId = config.getString("node.id", "dl580-01");
        this.serverUuid = config.getString("server.uuid", "");
        this.enabled = config.getBoolean("bridge.enabled", true);
        this.heartbeatInterval = config.getInt("bridge.heartbeat-interval", 30);
        this.inventoryUpdateInterval = config.getInt("bridge.inventory-update-interval", 5);
        this.antiCheatEnabled = config.getBoolean("anti-cheat.enabled", true);
        this.debugMode = config.getBoolean("debug", false);
    }

    public void reload() {
        loadConfig();
    }

    public void save() {
        config.set("platform.url", platformUrl);
        config.set("platform.bridge-secret", bridgeSecret);
        config.set("node.id", nodeId);
        config.set("server.uuid", serverUuid);
        config.set("bridge.enabled", enabled);
        config.set("bridge.heartbeat-interval", heartbeatInterval);
        config.set("bridge.inventory-update-interval", inventoryUpdateInterval);
        config.set("anti-cheat.enabled", antiCheatEnabled);
        config.set("debug", debugMode);
        
        try {
            config.save(configFile);
        } catch (IOException e) {
            plugin.getLogger().severe("Failed to save config: " + e.getMessage());
        }
    }

    public void setServerUuid(String uuid) {
        this.serverUuid = uuid;
        config.set("server.uuid", uuid);
    }

    // Getters
    public String getPlatformUrl() { return platformUrl; }
    public String getBridgeSecret() { return bridgeSecret; }
    public String getNodeId() { return nodeId; }
    public String getServerUuid() { return serverUuid; }
    public boolean isEnabled() { return enabled; }
    public int getHeartbeatInterval() { return heartbeatInterval; }
    public int getInventoryUpdateInterval() { return inventoryUpdateInterval; }
    public boolean isAntiCheatEnabled() { return antiCheatEnabled; }
    public boolean isDebugMode() { return debugMode; }
}
