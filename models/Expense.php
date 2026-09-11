<?php
class Expense extends Model {
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO expenses (user_id, category_id, description, amount, expense_date, notes)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['user_id'], $data['category_id'], $data['description'],
            $data['amount'], $data['expense_date'], $data['notes'] ?? null
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE expenses SET category_id=?, description=?, amount=?, expense_date=?, notes=?
             WHERE id=? AND user_id=?"
        );
        return $stmt->execute([
            $data['category_id'], $data['description'], $data['amount'],
            $data['expense_date'], $data['notes'] ?? null, $id, $data['user_id']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function allByUser(int $userId, string $search = '', string $category = ''): array {
        $sql = "SELECT e.*, c.category_name
                FROM expenses e
                JOIN categories c ON c.id=e.category_id
                WHERE e.user_id=?";
        $params = [$userId];

        if ($search !== '') {
            $sql .= " AND e.description LIKE ?";
            $params[] = "%$search%";
        }
        if ($category !== '') {
            $sql .= " AND e.category_id=?";
            $params[] = $category;
        }
        $sql .= " ORDER BY e.expense_date DESC, e.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id, int $userId): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM expenses WHERE id=? AND user_id=?"
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch() ?: null;
    }

    public function total(int $userId): float {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount),0) FROM expenses WHERE user_id=?");
        $stmt->execute([$userId]);
        return (float)$stmt->fetchColumn();
    }

    public function thisMonth(int $userId): float {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(amount),0) FROM expenses
             WHERE user_id=? AND YEAR(expense_date)=YEAR(CURDATE())
             AND MONTH(expense_date)=MONTH(CURDATE())"
        );
        $stmt->execute([$userId]);
        return (float)$stmt->fetchColumn();
    }

    public function today(int $userId): float {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(amount),0) FROM expenses
             WHERE user_id=? AND expense_date=CURDATE()"
        );
        $stmt->execute([$userId]);
        return (float)$stmt->fetchColumn();
    }

    public function count(int $userId): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM expenses WHERE user_id=?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function byCategory(int $userId): array {
        $stmt = $this->db->prepare(
            "SELECT c.category_name, COALESCE(SUM(e.amount),0) total
             FROM categories c
             LEFT JOIN expenses e ON e.category_id=c.id AND e.user_id=?
             GROUP BY c.id ORDER BY total DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
?>