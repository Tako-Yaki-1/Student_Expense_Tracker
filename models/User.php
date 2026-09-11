<?php
class User extends Model {
    public function create(array $data): bool {
        $sql = "INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'student'
        ]);
    }

    public function update(int $id, array $data): bool {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare(
                "UPDATE users SET name=?, username=?, password=? WHERE id=?"
            );
            return $stmt->execute([
                $data['name'], $data['username'],
                password_hash($data['password'], PASSWORD_DEFAULT), $id
            ]);
        }
        $stmt = $this->db->prepare("UPDATE users SET name=?, username=? WHERE id=?");
        return $stmt->execute([$data['name'], $data['username'], $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->execute([$username]);
        return $stmt->fetch() ?: null;
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}
?>