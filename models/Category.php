<?php
class Category extends Model {
    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO categories (category_name) VALUES (?)");
        return $stmt->execute([$data['category_name']]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE categories SET category_name=? WHERE id=?");
        return $stmt->execute([$data['category_name'], $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function all(): array {
        return $this->db->query("SELECT * FROM categories ORDER BY category_name")->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}
?>