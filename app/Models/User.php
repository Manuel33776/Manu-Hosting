<?php

namespace App\Models;

use App\Core\Database;
use App\Security\Csrf;

class User
{
    private Database $db;
    private Csrf $csrf;
    private string $table = 'users';

    public function __construct(Database $db, Csrf $csrf)
    {
        $this->db = $db;
        $this->csrf = $csrf;
    }

    public function create(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_ARGON2ID);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }

    public function findById(int $id): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE email = ?", [$email]);
    }

    public function findByUsername(string $username): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE username = ?", [$username]);
    }

    public function findByEmailOrUsername(string $identifier): ?array
    {
        return $this->db->queryOne(
            "SELECT * FROM {$this->table} WHERE email = ? OR username = ?",
            [$identifier, $identifier]
        );
    }

    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_ARGON2ID);
        }

        return $this->db->update($this->table, $data, 'id = ?', [$id]) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->delete($this->table, 'id = ?', [$id]) > 0;
    }

    public function getAll(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['role'])) {
            $where[] = 'role = ?';
            $params[] = $filters['role'];
        }

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $where[] = '(username LIKE ? OR email LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = ($page - 1) * $perPage;

        $users = $this->db->query(
            "SELECT * FROM {$this->table} {$whereSql} ORDER BY created_at DESC LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $total = $this->db->queryOne(
            "SELECT COUNT(*) as count FROM {$this->table} {$whereSql}",
            $params
        );

        return [
            'data' => $users,
            'total' => $total['count'] ?? 0,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil(($total['count'] ?? 0) / $perPage),
        ];
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_ARGON2ID);
    }

    public function updateLastLogin(int $id): void
    {
        $this->db->update($this->table, [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ], 'id = ?', [$id]);
    }

    public function getStats(): array
    {
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table}");
        $active = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'active'");
        $admins = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE role IN ('owner', 'admin', 'support')");
        $customers = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE role = 'customer'");

        return [
            'total' => $total['count'] ?? 0,
            'active' => $active['count'] ?? 0,
            'admins' => $admins['count'] ?? 0,
            'customers' => $customers['count'] ?? 0,
        ];
    }

    public function getRoles(): array
    {
        return ['owner', 'admin', 'support', 'customer', 'subuser'];
    }

    public function getPermissions(): array
    {
        return [
            'owner' => ['*'],
            'admin' => [
                'admin.servers.view',
                'admin.servers.start',
                'admin.servers.stop',
                'admin.servers.restart',
                'admin.servers.suspend',
                'admin.servers.delete',
                'admin.customers.view',
                'admin.customers.manage',
                'admin.tickets.manage',
                'admin.inventory.view',
                'admin.anticheat.manage',
                'admin.resources.view',
                'admin.nodes.view',
                'admin.platform.maintenance',
            ],
            'support' => [
                'admin.tickets.manage',
                'admin.customers.view',
                'admin.servers.view',
            ],
            'customer' => [
                'customer.servers.view',
                'customer.servers.start',
                'customer.servers.stop',
                'customer.servers.restart',
                'customer.servers.console',
                'customer.servers.logs',
                'customer.servers.files',
                'customer.servers.backups',
                'customer.servers.schedule',
                'customer.players.manage',
                'customer.inventory.view',
            ],
            'subuser' => [
                'customer.servers.view',
                'customer.servers.console',
                'customer.servers.logs',
            ],
        ];
    }
}
