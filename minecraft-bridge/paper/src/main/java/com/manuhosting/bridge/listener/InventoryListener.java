package com.manuhosting.bridge.listener;

import com.manuhosting.bridge.ManuHostingBridge;
import com.manuhosting.bridge.api.ApiClient;
import com.google.gson.JsonObject;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.EventPriority;
import org.bukkit.event.Listener;
import org.bukkit.event.inventory.InventoryClickEvent;
import org.bukkit.event.inventory.InventoryCloseEvent;
import org.bukkit.event.player.PlayerDropItemEvent;
import org.bukkit.event.player.PlayerPickupItemEvent;
import org.bukkit.inventory.Inventory;
import org.bukkit.inventory.ItemStack;

import java.util.HashMap;
import java.util.Map;
import java.util.UUID;

public class InventoryListener implements Listener {

    private final ManuHostingBridge plugin;
    private final ApiClient apiClient;
    private final Map<UUID, Long> lastUpdate;

    public InventoryListener(ManuHostingBridge plugin) {
        this.plugin = plugin;
        this.apiClient = plugin.getApiClient();
        this.lastUpdate = new HashMap<>();
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onInventoryClick(InventoryClickEvent event) {
        if (!(event.getWhoClicked() instanceof Player)) return;
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        Player player = (Player) event.getWhoClicked();
        scheduleInventoryUpdate(player);
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onInventoryClose(InventoryCloseEvent event) {
        if (!(event.getPlayer() instanceof Player)) return;
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        Player player = (Player) event.getPlayer();
        updateInventoryNow(player);
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onPlayerDropItem(PlayerDropItemEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        Player player = event.getPlayer();
        scheduleInventoryUpdate(player);
    }

    @EventHandler(priority = EventPriority.MONITOR, ignoreCancelled = true)
    public void onPlayerPickupItem(PlayerPickupItemEvent event) {
        if (!plugin.isBridgeEnabled() || apiClient == null) return;
        Player player = event.getPlayer();
        scheduleInventoryUpdate(player);
    }

    private void scheduleInventoryUpdate(Player player) {
        UUID uuid = player.getUniqueId();
        long now = System.currentTimeMillis();
        long last = lastUpdate.getOrDefault(uuid, 0L);
        int interval = plugin.getBridgeConfig().getInventoryUpdateInterval() * 1000;
        if (now - last >= interval) {
            updateInventoryNow(player);
        } else {
            plugin.getServer().getScheduler().runTaskLaterAsynchronously(plugin, () -> {
                if (player.isOnline()) updateInventoryNow(player);
            }, 20L * (interval / 1000 + 1));
        }
    }

    private void updateInventoryNow(Player player) {
        lastUpdate.put(player.getUniqueId(), System.currentTimeMillis());
        plugin.getServer().getScheduler().runTaskAsynchronously(plugin, () -> {
            try {
                JsonObject inventory = serializeInventory(player.getInventory());
                JsonObject enderchest = serializeInventory(player.getEnderChest());
                apiClient.sendInventoryUpdate(player.getUniqueId().toString(), player.getName(), inventory, enderchest);
                if (plugin.getBridgeConfig().isDebugMode()) {
                    plugin.getLogger().info("Inventory updated for: " + player.getName());
                }
            } catch (Exception e) {
                plugin.getLogger().warning("Error updating inventory for " + player.getName() + ": " + e.getMessage());
            }
        });
    }

    private JsonObject serializeInventory(Inventory inventory) {
        JsonObject result = new JsonObject();
        if (inventory == null) return result;
        for (int i = 0; i < inventory.getSize(); i++) {
            ItemStack item = inventory.getItem(i);
            if (item != null && item.getType() != org.bukkit.Material.AIR) {
                result.add(String.valueOf(i), serializeItemStack(item));
            }
        }
        return result;
    }

    private JsonObject serializeItemStack(ItemStack item) {
        JsonObject json = new JsonObject();
        json.addProperty("type", item.getType().name());
        json.addProperty("amount", item.getAmount());
        json.addProperty("durability", item.getDurability());
        if (!item.getEnchantments().isEmpty()) {
            JsonObject enchants = new JsonObject();
            item.getEnchantments().forEach((ench, level) -> enchants.addProperty(ench.getKey().getKey(), level));
            json.add("enchantments", enchants);
        }
        if (item.hasItemMeta()) {
            var meta = item.getItemMeta();
            if (meta.hasDisplayName()) json.addProperty("display_name", meta.getDisplayName());
            if (meta.hasLore()) {
                JsonObject lore = new JsonObject();
                for (int i = 0; i < meta.getLore().size(); i++) lore.addProperty(String.valueOf(i), meta.getLore().get(i));
                json.add("lore", lore);
            }
            if (meta.hasCustomModelData()) json.addProperty("custom_model_data", meta.getCustomModelData());
        }
        return json;
    }
}
