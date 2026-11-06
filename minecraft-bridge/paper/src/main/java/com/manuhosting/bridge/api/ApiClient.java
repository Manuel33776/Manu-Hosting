package com.manuhosting.bridge.api;

import com.manuhosting.bridge.ManuHostingBridge;
import com.manuhosting.bridge.config.BridgeConfig;
import com.google.gson.Gson;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;
import java.util.logging.Level;

public class ApiClient {

    private final ManuHostingBridge plugin;
    private final BridgeConfig config;
    private final Gson gson;
    private final Map<String, Long> lastInventoryUpdate;

    public ApiClient(BridgeConfig config) {
        this.plugin = ManuHostingBridge.getInstance();
        this.config = config;
        this.gson = new Gson();
        this.lastInventoryUpdate = new ConcurrentHashMap<>();
    }

    private HttpURLConnection createConnection(String endpoint, String method) throws Exception {
        String url = config.getPlatformUrl().replaceAll("/$", "") + "/api/v1/bridge" + endpoint;
        HttpURLConnection conn = (HttpURLConnection) new URL(url).openConnection();
        conn.setRequestMethod(method);
        conn.setRequestProperty("Content-Type", "application/json");
        conn.setRequestProperty("Accept", "application/json");
        conn.setRequestProperty("User-Agent", "ManuHostingBridge/1.0");
        conn.setRequestProperty("X-Bridge-Secret", config.getBridgeSecret());
        conn.setRequestProperty("X-Server-UUID", config.getServerUuid());
        conn.setConnectTimeout(10000);
        conn.setReadTimeout(30000);
        return conn;
    }

    private JsonObject sendRequest(String endpoint, String method, JsonObject payload) {
        try {
            HttpURLConnection conn = createConnection(endpoint, method);
            
            if (payload != null && (method.equals("POST") || method.equals("PUT"))) {
                conn.setDoOutput(true);
                try (OutputStream os = conn.getOutputStream()) {
                    byte[] input = gson.toJson(payload).getBytes(StandardCharsets.UTF_8);
                    os.write(input, 0, input.length);
                }
            }
            
            int responseCode = conn.getResponseCode();
            String response;
            
            try (var is = responseCode >= 400 ? conn.getErrorStream() : conn.getInputStream()) {
                if (is == null) return null;
                response = new String(is.readAllBytes(), StandardCharsets.UTF_8);
            }
            
            if (config.isDebugMode()) {
                plugin.getLogger().info("API " + method + " " + endpoint + " -> " + responseCode + ": " + response);
            }
            
            if (responseCode >= 200 && responseCode < 300) {
                return JsonParser.parseString(response).getAsJsonObject();
            } else {
                plugin.getLogger().warning("API error " + responseCode + ": " + response);
                return null;
            }
        } catch (Exception e) {
            plugin.getLogger().log(Level.WARNING, "API request failed: " + e.getMessage(), e);
            return null;
        }
    }

    public boolean registerServer(String uuid, String name, String version, String bukkitVersion, String nodeId) {
        JsonObject payload = new JsonObject();
        payload.addProperty("uuid", uuid);
        payload.addProperty("name", name);
        payload.addProperty("version", version);
        payload.addProperty("bukkit_version", bukkitVersion);
        payload.addProperty("node_id", nodeId);
        
        JsonObject response = sendRequest("/server/register", "POST", payload);
        return response != null && response.has("success") && response.get("success").getAsBoolean();
    }

    public boolean sendServerStatus(String status, int playersOnline, int playersMax, int cpuUsage, int ramUsage) {
        JsonObject payload = new JsonObject();
        payload.addProperty("status", status);
        payload.addProperty("players_online", playersOnline);
        payload.addProperty("players_max", playersMax);
        payload.addProperty("cpu_usage", cpuUsage);
        payload.addProperty("ram_usage", ramUsage);
        
        JsonObject response = sendRequest("/server/status", "POST", payload);
        return response != null && response.has("success") && response.get("success").getAsBoolean();
    }

    public boolean sendPlayerJoin(String playerUuid, String playerName, int playersOnline) {
        JsonObject payload = new JsonObject();
        payload.addProperty("server_uuid", config.getServerUuid());
        payload.addProperty("player_uuid", playerUuid);
        payload.addProperty("player_name", playerName);
        payload.addProperty("players_online", playersOnline);
        payload.addProperty("event", "join");
        
        JsonObject response = sendRequest("/player/join", "POST", payload);
        return response != null && response.has("success") && response.get("success").getAsBoolean();
    }

    public boolean sendPlayerQuit(String playerUuid, String playerName, int playersOnline) {
        JsonObject payload = new JsonObject();
        payload.addProperty("server_uuid", config.getServerUuid());
        payload.addProperty("player_uuid", playerUuid);
        payload.addProperty("player_name", playerName);
        payload.addProperty("players_online", playersOnline);
        payload.addProperty("event", "quit");
        
        JsonObject response = sendRequest("/player/quit", "POST", payload);
        return response != null && response.has("success") && response.get("success").getAsBoolean();
    }

    public boolean sendInventoryUpdate(String playerUuid, String playerName, JsonObject inventory, JsonObject enderchest) {
        String key = playerUuid + "-inv";
        long now = System.currentTimeMillis();
        long lastUpdate = lastInventoryUpdate.getOrDefault(key, 0L);
        
        // Throttle inventory updates
        if (now - lastUpdate < config.getInventoryUpdateInterval() * 1000) {
            return false;
        }
        lastInventoryUpdate.put(key, now);
        
        JsonObject payload = new JsonObject();
        payload.addProperty("server_uuid", config.getServerUuid());
        payload.addProperty("player_uuid", playerUuid);
        payload.addProperty("player_name", playerName);
        payload.add("inventory", inventory);
        payload.add("enderchest", enderchest != null ? enderchest : new JsonObject());
        
        JsonObject response = sendRequest("/inventory/update", "POST", payload);
        return response != null && response.has("success") && response.get("success").getAsBoolean();
    }

    public boolean sendAntiCheatAlert(String playerUuid, String playerName, String rule, String severity, JsonObject details, JsonObject evidence) {
        if (!config.isAntiCheatEnabled()) return false;
        
        JsonObject payload = new JsonObject();
        payload.addProperty("server_uuid", config.getServerUuid());
        payload.addProperty("player_uuid", playerUuid);
        payload.addProperty("player_name", playerName);
        payload.addProperty("rule", rule);
        payload.addProperty("severity", severity);
        payload.add("details", details != null ? details : new JsonObject());
        payload.add("evidence", evidence != null ? evidence : new JsonObject());
        
        JsonObject response = sendRequest("/anticheat/alert", "POST", payload);
        return response != null && response.has("success") && response.get("success").getAsBoolean();
    }

    public boolean testConnection() {
        JsonObject response = sendRequest("/test", "GET", null);
        return response != null;
    }
}
