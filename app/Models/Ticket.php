<?php

namespace App\Models;

use App\Core\Database;

class Ticket
{
    private Database $db;
    private string $table = 'tickets';
    private string $messagesTable = 'ticket_messages';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $data['ticket_number'] = $data['ticket_number'] ?? $this->generateTicketNumber();
        $data['status'] = $data['status'] ?? 'open';
        $data['priority'] = $data['priority'] ?? 'normal';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    private function generateTicketNumber(): string
    {
        return 'TKT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
    }

    public function findById(int $id): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findByTicketNumber(string $ticketNumber): ?array
    {
        return $this->db->queryOne("SELECT * FROM {$this->table} WHERE ticket_number = ?", [$ticketNumber]);
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

        if (!empty($filters['assigned_to'])) {
            $where[] = 'assigned_to = ?';
            $params[] = $filters['assigned_to'];
        }

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['priority'])) {
            $where[] = 'priority = ?';
            $params[] = $filters['priority'];
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = ($page - 1) * $perPage;

        $tickets = $this->db->query(
            "SELECT t.*, u.username, u.email, a.username as assigned_name
             FROM {$this->table} t
             LEFT JOIN users u ON t.user_id = u.id
             LEFT JOIN users a ON t.assigned_to = a.id
             {$whereSql}
             ORDER BY 
                 CASE t.priority 
                     WHEN 'urgent' THEN 1 
                     WHEN 'high' THEN 2 
                     WHEN 'normal' THEN 3 
                     WHEN 'low' THEN 4 
                 END,
                 t.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $total = $this->db->queryOne(
            "SELECT COUNT(*) as count FROM {$this->table} {$whereSql}",
            $params
        );

        return [
            'data' => $tickets,
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

    public function addMessage(int $ticketId, int $userId, string $message, bool $isStaff = false, array $attachments = []): int
    {
        return $this->db->insert($this->messagesTable, [
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'message' => $message,
            'is_staff' => $isStaff,
            'attachments' => json_encode($attachments),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getMessages(int $ticketId): array
    {
        return $this->db->query(
            "SELECT m.*, u.username, u.role
             FROM {$this->messagesTable} m
             LEFT JOIN users u ON m.user_id = u.id
             WHERE m.ticket_id = ?
             ORDER BY m.created_at ASC",
            [$ticketId]
        );
    }

    public function getStats(): array
    {
        $total = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table}");
        $open = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'open'");
        $inProgress = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'in_progress'");
        $waitingCustomer = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'waiting_customer'");
        $waitingSupport = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'waiting_support'");
        $closed = $this->db->queryOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'closed'");

        return [
            'total' => $total['count'] ?? 0,
            'open' => $open['count'] ?? 0,
            'in_progress' => $inProgress['count'] ?? 0,
            'waiting_customer' => $waitingCustomer['count'] ?? 0,
            'waiting_support' => $waitingSupport['count'] ?? 0,
            'closed' => $closed['count'] ?? 0,
        ];
}
}
