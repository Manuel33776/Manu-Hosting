<?php

namespace App\Models;

use App\Core\Database;

class Backup
{
    private Database $db;
    private string $table = 'backups';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $data['uuid'] = $data['uuid'] ?? $this->generateUuid();
        $data['status'] = $data['status'] ?? 'pending';
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function findById(int $id): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findByUuid(string $uuid): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE uuid = ?", [$uuid]);
    }

    public function findByServerId(int $serverId): array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE server_id = ? ORDER BY created_at DESC",
            [$serverId]
        );
    }

    public function getAll(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['server_id'])) {
            $where[] = 'server_id = ?';
            $params[] = $filters['server_id'];
        }

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = ($page - 1) * $perPage;

        $backups = $this->db->query(
            "SELECT b.*, s.name as server_name, s.uuid as server_uuid
             FROM {$this->table} b
             LEFT JOIN servers s ON b.server_id = s.id
             {$whereSql}
             ORDER BY b.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $total = $this->db->queryOne(
            "SELECT COUNT(*) as count FROM {$this->table} {$whereSql}",
            $params
        );

        return [
            'data' => $backups,
            'total' => $total['count'] ?? 0,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil(($total['count'] ?? 0) / $perPage),
        ];
    }

    public function update(int $id, array $data): bool
0
    {
        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function updateStatus(int $id, string $status, array $extra = []): bool
    {
        $data = array_merge(['status' => $status], $extra);
        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->delete($this->table, 'id = ?', [$id]) > 0;
    }

    public function getStats(): array
    {
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table}");
        $pending = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'pending'");
        $running = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'running'");
        $completed = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'completed'");
        $failed = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'failed'");
        
        $totalSize = $this->db->queryOne("SELECT SUM(size) as total FROM {$this->table} WHERE status = 'completed'");

        return [
            'total' => $total['count'] ?? 0,
            'pending' => $pending['count'] ?? 0,
            'running' => $running['count'] ?? 0,
            'completed' => $completed['count'] ?? 0,
            'failed' => $failed['count'] ?? 0,
            'total_size' => $totalSize['total'] ?? 0,
        ];
}
}
