<?php

namespace App\Models;

use App\Core\Database;

class Server
{
    private Database $db;
    private string $table = 'servers';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $data['uuid'] = $data['uuid'] ?? $this->generateUuid();
        $data['status'] = $data['status'] ?? 'creating';
        $data['idle_shutdown_enabled'] = $data['idle_shutdown_enabled'] ?? true;
        $data['idle_shutdown_timeout'] = $data['idle_shutdown_timeout'] ?? 60;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
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

    public function findByUserId(int $userId): array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
    }

    public function findByNodeId(int $nodeId): array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE node_id = ? ORDER BY created_at DESC",
            [$nodeId]
        );
    }

    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function updateByUuid(string $uuid, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, 'uuid = ?', [$uuid]) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->delete($this->table, 'id = ?', [$id]) > 0;
    }

    public function getAll(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['node_id'])) {
            $where[] = 'node_id = ?';
            $params[] = $filters['node_id'];
        }

        if (!empty($filters['user_id'])) {
            $where[] = 'user_id = ?';
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['software'])) {
            $where[] = 'software = ?';
            $params[] = $filters['software'];
        }

        if (!empty($filters['search'])) {
            $where[] = '(name LIKE ? OR uuid LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = ($page - 1) * $perPage;

        $servers = $this->db->query(
            "SELECT s.*, n.name as node_name, u.username as owner_name
             FROM {$this->table} s
             LEFT JOIN nodes n ON s.node_id = n.id
             LEFT JOIN users u ON s.user_id = u.id
             {$whereSql}
             ORDER BY s.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $total = $this->db->queryOne(
            "SELECT COUNT(*) as count FROM {$this->table} {$whereSql}",
            $params
        );

        return [
            'data' => $servers,
            'total' => $total['count'] ?? 0,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil(($total['count'] ?? 0) / $perPage),
        ];
    }

    public function getStats(): array
    {
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table}");
        $online = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'online'");
        $offline = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'offline'");
        $starting = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'starting'");
        $stopping = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'stopping'");
        $error = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'error'");
        $suspended = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'suspended'");
        $idle = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'idle_shutdown'");
        $installing = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'installing'");

        return [
            'total' => $total['count'] ?? 0,
            'online' => $online['count'] ?? 0,
            'offline' => $offline['count'] ?? 0,
            'starting' => $starting['count'] ?? 0,
            'stopping' => $stopping['count'] ?? 0,
            'error' => $error['count'] ?? 0,
            'suspended' => $suspended['count'] ?? 0,
            'idle_shutdown' => $idle['count'] ?? 0,
            'installing' => $installing['count'] ?? 0,
        ];
    }

    public function getResourceUsage(string $uuid): ?array
    {
        return $this->db->queryOne(
            "SELECT * FROM server_resources WHERE server_uuid = ? ORDER BY recorded_at DESC LIMIT 1",
            [$uuid]
        );
    }

    public function recordResourceUsage(string $uuid, array $data): void
    {
        $data['server_uuid'] = $uuid;
        $data['recorded_at'] = date('Y-m-d H:i:s');
        $this->db->insert('server_resources', $data);
    }

    public function getIdleShutdownConfig(string $uuid): array
    {
        $server = $this->findByUuid($uuid);
        if (!$server) {
            return ['enabled' => true, 'timeout' => 60];
        }
        return [
            'enabled' => (bool)($server['idle_shutdown_enabled'] ?? true),
            'timeout' => (int)($server['idle_shutdown_timeout'] ?? 60),
        ];
    }

    public function setIdleShutdownConfig(string $uuid, bool $enabled, int $timeout): bool
0
    {
        return $this->updateByUuid($uuid, [
            'idle_shutdown_enabled' => $enabled,
            'idle_shutdown_timeout' => $timeout,
        ]);
    }
}
