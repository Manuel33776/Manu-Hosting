<?php

namespace App\Models;

use App\Core\Database;

class Package
{
    private Database $db;
    private string $table = 'packages';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function findById(int $id): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function getAll(bool $activeOnly = true): array
    {
        $where = $activeOnly ? 'WHERE is_active = 1' : '';
        return $this->db->query("SELECT * FROM {$this->table} {$where} ORDER BY sort_order ASC, ram ASC");
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

    public function getWithServersCount(): array
    {
        return $this->db->query(
            "SELECT p.*, COUNT(s.id) as servers_count
             FROM {$this->table} p
             LEFT JOIN servers s ON p.id = s.package_id
             WHERE p.is_active = 1
             GROUP BY p.id
             ORDER BY p.sort_order ASC, p.ram ASC"
        );
    }
}
