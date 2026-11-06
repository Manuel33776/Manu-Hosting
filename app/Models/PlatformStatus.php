<?php

namespace App\Models;

use App\Core\Database;

class PlatformStatus
{
    private Database $db;
    private string $table = 'platform_status';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Website Maintenance
    public function getMaintenanceStatus(): array
    {
        $result = $this->db->queryOne("SELECT * FROM {$this->table} WHERE type = 'maintenance' ORDER BY id DESC LIMIT 1");
        return $result ?? [
            'type' => 'maintenance',
            'enabled' => false,
            'message' => '',
            'started_at' => null,
            'planned_end_at' => null,
            'ended_at' => null,
        ];
    }

    public function setMaintenance(array $data): int
    {
        $data['type'] = 'maintenance';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Deactivate current maintenance
        $this->db->execute("UPDATE {$this->table} SET enabled = 0 WHERE type = 'maintenance' AND enabled = 1");
        
        return $this->db->insert($this->table, $data);
    }

    public function endMaintenance(): bool
    {
        return $this->db->execute(
            "UPDATE {$this->table} SET enabled = 0, ended_at = ?, updated_at = ? WHERE type = 'maintenance' AND enabled = 1",
            [date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]
        ) > 0;
    }

    public function getMaintenanceHistory(int $limit = 50): array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE type = 'maintenance' ORDER BY created_at DESC LIMIT ?",
            [$limit]
        );
    }

    // Work in Progress
    public function getWipStatus(): array
    {
        $result = $this->db->queryOne("SELECT * FROM {$this->table} WHERE type = 'wip' ORDER BY id DESC LIMIT 1");
        return $result ?? [
            'type' => 'wip',
            'enabled' => true,
            'message' => '',
        ];
    }

    public function setWipStatus(bool $enabled, string $message = ''): int
    {
        $data = [
            'type' => 'wip',
            'enabled' => $enabled,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $this->db->execute("UPDATE {$this->table} SET enabled = 0 WHERE type = 'wip'");
        return $this->db->insert($this->table, $data);
    }

    // Servers Offline
    public function getServersOfflineStatus(): array
    {
        $result = $this->db->queryOne("SELECT * FROM {$this->table} WHERE type = 'servers_offline' ORDER BY id DESC LIMIT 1");
        return $result ?? [
            'type' => 'servers_offline',
            'enabled' => true,
            'message' => '',
        ];
    }

    public function setServersOfflineStatus(bool $enabled, string $message = ''): int
    {
        $data = [
            'type' => 'servers_offline',
            'enabled' => $enabled,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $this->db->execute("UPDATE {$this->table} SET enabled = 0 WHERE type = 'servers_offline'");
        return $this->db->insert($this->table, $data);
    }

    // General platform status for status page
    public function getOverallStatus(): array
    {
        $components = [
            'website' => $this->checkWebsite(),
            'api' => $this->checkApi(),
            'database' => $this->checkDatabase(),
            'nodes' => $this->checkNodes(),
        ];

        $overall = 'operational';
        foreach ($components as $component) {
            if ($component['status'] === 'degraded') {
                $overall = 'degraded';
            } elseif ($component['status'] === 'outage' && $overall !== 'outage') {
                $overall = 'outage';
            }
        }

        return [
            'overall' => $overall,
            'components' => $components,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

    private function checkWebsite(): array
    {
        return ['name' => 'Website', 'status' => 'operational'];
    }

    private function checkApi(): array
    {
        return ['name' => 'API', 'status' => 'operational'];
    }

    private function checkDatabase(): array
    {
        try {
            $this->db->queryOne('SELECT 1');
            return ['name' => 'Datenbank', 'status' => 'operational'];
        } catch (\Throwable $e) {
            return ['name' => 'Datenbank', 'status' => 'outage'];
        }
    }

    private function checkNodes(): array
    {
        $online = $this->db->queryOne("SELECT COUNT(*) as count FROM nodes WHERE status = 'online'");
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM nodes");
        
        if ($total['count'] === 0) {
            return ['name' => 'Minecraft Nodes', 'status' => 'operational', 'detail' => 'Keine Nodes konfiguriert'];
        }
        
        if ($online['count'] === 0) {
            return ['name' => 'Minecraft Nodes', 'status' => 'outage', 'detail' => 'Alle Nodes offline'];
        }
        
        if ($online['count'] < $total['count']) {
            return ['name' => 'Minecraft Nodes', 'status' => 'degraded', 'detail' => "{$online['count']}/{$total['count']} Nodes online"];
        }
        
        return ['name' => 'Minecraft Nodes', 'status' => 'operational', 'detail' => "{$online['count']}/{$total['count']} Nodes online"];
    }
}
