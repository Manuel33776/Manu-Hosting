package com.manuhosting.bridge.listener;

import com.manuhosting.bridge.ManuHostingBridge;
import com.manuhosting.bridge.api.ApiClient;
import com.google.gson.JsonObject;
import org.bukkit.Bukkit;
import org.bukkit.GameMode;
import org.bukkit.Location;
import org.bukkit.Material;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.EventPriority;
import org.bukkit.event.Listener;
import org.bukkit.event.entity.EntityDamageByEntityEvent;
import org.bukkit.event.player.PlayerMoveEvent;
import org.bukkit.event.player.PlayerInteractEvent;
import org.bukkit.event.block.BlockBreakEvent;
import org.bukkit.inventory.ItemStack;
import org.bukkit.potion.PotionEffectType;

import java.util.HashMap;
import java.util.Map;
import java.util.UUID;

public class AntiCheatListener implements Listener {

    private final ManuHostingBridge plugin;
    private final ApiClient apiClient;
    private final Map<UUID, Location> lastLocations;
    private final Map<UUID, Integer> moveViolations;
    private final Map<UUID, Long> lastBreakTime;
    private final Map<UUID, Integer> breakSpeedViolations;

    public AntiCheatListener(ManuHostingBridge plugin) {
        this.plugin = plugin;
        this.apiClient = plugin.getApiClient();
        this.lastLocations = new HashMap<>();
        this.moveViolations = new HashMap<>();
        this.lastBreakTime = new HashMap<>();
        this.breakSpeedViolations = new HashMap<>();
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onPlayerMove(PlayerMoveEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null || !plugin.getBridgeConfig().isAntiCheatEnabled()) return;
        if (event.getFrom().getX() == event.getTo().getX() && event.getFrom().getZ() == event.getTo().getZ()) return;
        
        Player player = event.getPlayer();
        if (player.getGameMode() == GameMode.CREATIVE || player.getGameMode() == GameMode.SPECTATOR) return;
        if (player.hasPermission("manubridge.bypass")) return;
        
        // Check for fly/speed hack
        Location from = event.getFrom();
        Location to = event.getTo();
        double distance = from.distance(to);
        double maxDistance = 0.5; // Normal walk speed per tick
        
        if (player.isFlying() || player.getAllowFlight()) {
            maxDistance = 1.0;
        }
        if (player.isSprinting()) maxDistance *= 1.3;
        if (player.hasPotionEffect(PotionEffectType.SPEED)) maxDistance *= 1.5;
        if (player.isOnGround()) maxDistance *= 1.2;
        
        if (distance > maxDistance) {
            int violations = moveViolations.merge(player.getUniqueId(), 1, Integer::sum);
            if (violations >= 5) {
                sendAlert(player, "fly_speed", "HIGH", 
                    createDetails("distance", distance, "max_allowed", maxDistance, "violations", violations),
                    createEvidence("from", from, "to", to));
                moveViolations.put(player.getUniqueId(), 0);
            }
        } else {
            moveViolations.put(player.getUniqueId(), 0);
        }
        
        lastLocations.put(player.getUniqueId(), to.clone());
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onEntityDamage(EntityDamageByEntityEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null || !plugin.getBridgeConfig().isAntiCheatEnabled()) return;
        if (!(event.getDamager() instanceof Player)) return;
        
        Player player = (Player) event.getDamager();
        if (player.getGameMode() == GameMode.CREATIVE) return;
        
        // Check for reach hack
        double reach = player.getLocation().distance(event.getEntity().getLocation());
        double maxReach = 3.5; // Normal reach in blocks
        if (player.getInventory().getItemInMainHand().getType() != Material.AIR) {
            maxReach = 4.5; // With tool
        }
        
        if (reach > maxReach + 0.5) {
            sendAlert(player, "reach", "HIGH",
                createDetails("reach", reach, "max_allowed", maxReach),
                createEvidence("target", event.getEntity().getLocation(), "player", player.getLocation()));
        }
        
        // Check for kill aura (too many hits per second)
        // This would need more sophisticated tracking
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onBlockBreak(BlockBreakEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null || !plugin.getBridgeConfig().isAntiCheatEnabled()) return;
        
        Player player = event.getPlayer();
        if (player.getGameMode() == GameMode.CREATIVE) return;
        if (player.hasPermission("manubridge.bypass")) return;
        
        // Check for fast break / auto-break
        UUID uuid = player.getUniqueId();
        long now = System.currentTimeMillis();
        long lastBreak = lastBreakTime.getOrDefault(uuid, 0L);
        
        if (now - lastBreak < 50) { // Less than 50ms between breaks = suspicious
            int violations = breakSpeedViolations.merge(uuid, 1, Integer::sum);
            if (violations >= 10) {
                sendAlert(player, "fast_break", "MEDIUM",
                    createDetails("break_interval_ms", now - lastBreak, "violations", violations),
                    createEvidence("block", event.getBlock().getLocation()));
                breakSpeedViolations.put(uuid, 0);
            }
        } else {
            breakSpeedViolations.put(uuid, 0);
        }
        
        lastBreakTime.put(uuid, now);
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onPlayerInteract(PlayerInteractEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null || !plugin.getBridgeConfig().isAntiCheatEnabled()) return;
        
        Player player = event.getPlayer();
        ItemStack item = event.getItem();
        
        // Check for impossible stack sizes or invalid items
        if (item != null && item.getAmount() > item.getMaxStackSize()) {
            sendAlert(player, "invalid_stack_size", "HIGH",
                createDetails("item", item.getType().name(), "amount", item.getAmount(), "max_stack", item.getMaxStackSize()),
                createEvidence("slot", event.getHand().name()));
        }
    }

    private void sendAlert(Player player, String rule, String severity, JsonObject details, JsonObject evidence) {
        plugin.getServer().getScheduler().runTaskAsynchronously(plugin, () -> {
            try {
                apiClient.sendAntiCheatAlert(
                    player.getUniqueId().toString(),
                    player.getName(),
                    rule,
                    severity,
                    details,
                    evidence
                );
                if (plugin.getBridgeConfig().isDebugMode()) {
                    plugin.getLogger().warning("Anti-cheat alert: " + player.getName() + " - " + rule + " (" + severity + ")");
                }
            } catch (Exception e) {
                plugin.getLogger().warning("Error sending anti-cheat alert: " + e.getMessage());
            }
        });
    }

    private JsonObject createDetails(Object... keyValues) {
        JsonObject obj = new JsonObject();
        for (int i = 0; i < keyValues.length; i += 2) {
            String key = (String) keyValues[i];
            Object value = keyValues[i + 1];
            if (value instanceof Number) obj.addProperty(key, (Number) value);
            else if (value instanceof Boolean) obj.addProperty(key, (Boolean) value);
            else if (value instanceof Location) obj.addProperty(key, locationToString((Location) value));
            else obj.addProperty(key, String.valueOf(value));
        }
        return obj;
    }

    private JsonObject createEvidence(Object... keyValues) {
        return createDetails(keyValues);
    }

    private String locationToString(Location loc) {
        return String.format("%.2f, %.2f, %.2f (world: %s)", loc.getX(), loc.getY(), loc.getZ(), loc.getWorld().getName());
    }
}
