<?php

namespace App\Models;

use App\Core\Database;

class Order
{
    private Database $db;
    private string $table = 'orders';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $data['order_number'] = $data['order_number'] ?? $this->generateOrderNumber();
        $data['status'] = $data['status'] ?? 'pending';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    private function generateOrderNumber(): string
    {
        return 'MH-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
    }

    public function findById(int $id): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findByOrderNumber(string $orderNumber): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE order_number = ?", [$orderNumber]);
    }

    public function findByUserId(int $userId): array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
    }

    public function getAll(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['user_id'])) {
            $where[] = 'user_id = ?';
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['package_id'])) {
            $where[] = 'package_id = ?';
            $params[] = $filters['package_id'];
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = ($page - 1) * $perPage;

        $orders = $this->db->query(
            "SELECT o.*, u.username, u.email, p.name as package_name
             FROM {$this->table} o
             LEFT JOIN users u ON o.user_id = u.id
             LEFT JOIN packages p ON o.package_id = p.id
             {$whereSql}
             ORDER BY o.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $total = $this->db->queryOne(
            "SELECT COUNT(*) as count FROM {$this->table} {$whereSql}",
            $params
        );

        return [
            'data' => $orders,
            'total' => $total['count'] ?? 0,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil(($total['count'] ?? 0) / $perPage),
        ];
    }

    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function updateStatus(int $id, string $status): bool
    {
        return $this->db->update($this->table, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ], 'id = ?', [$id]) > 0;
    }

    public function getStats(): array
    {
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table}");
        $pending = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'pending'");
        $processing = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'processing'");
        $completed = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'completed'");
        $cancelled = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'cancelled'");
        $failed = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'failed'");
        
        $revenue = $this->db->queryOne(
            "SELECT SUM(amount) as total FROM {$this->table} WHERE status = 'completed'"
        );

        return [
            'total' => $total['count'] ?? 0,
            'pending' => $pending['count'] ?? 0,
            'processing' => $processing['count'] ?? 0,
            'completed' => $completed['count'] ?? 0,
            'cancelled' => $cancelled['count'] ?? 0,
            'failed' => $failed['count'] ?? 0,
            'revenue' => $revenue['total'] ?? 0,
        ];
}
}
