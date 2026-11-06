<?php

namespace App\Models;

use App\Core\Database;

class Node
{
    private Database $db;
    private string $table = 'nodes';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $data['token'] = $data['token'] ?? $this->generateToken();
        $data['status'] = $data['status'] ?? 'offline';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }

    private function generateToken(): string
    {
        return 'node_' . bin2hex(random_bytes(32));
    }

    public function findById(int $id): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findByToken(string $token): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE token = ?", [$token]);
    }

    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }

    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->delete($this->table, 'id = ?', [$id]) > 0;
    }

    public function updateHeartbeat(int $id, array $data): bool
    {
        $data['last_heartbeat'] = date('Y-m-d H:i:s');
        $data['status'] = 'online';
        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function markOffline(int $id): bool
    {
        return $this->db->update($this->table, [
            'status' => 'offline',
            'updated_at' => date('Y-m-d H:i:s'),
        ], 'id = ?', [$id]) > 0;
    }

    public function getOnlineNodes(): array
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE status = 'online'");
    }

    public function getStats(): array
    {
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table}");
        $online = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'online'");
        $offline = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'offline'");
        
        $resources = $this->db->queryOne(
            "SELECT 
                SUM(cpu_cores) as total_cores,
                SUM(cpu_usage) as total_cpu_usage,
                SUM(ram_total) as total_ram,
                SUM(ram_used) as total_ram_used,
                SUM(disk_total) as total_disk,
                SUM(disk_used) as total_disk_used
             FROM {$this->table} WHERE status = 'online'"
        );

        return [
            'total' => $total['count'] ?? 0,
            'online' => $online['count'] ?? 0,
            'offline' => $offline['count'] ?? 0,
            'resources' => $resources,
        ];
    }
}
