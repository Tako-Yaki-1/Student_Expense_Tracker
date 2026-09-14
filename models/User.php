<?php
class User extends Model {
    public function create(array $data): bool {
        $users = $this->storage->get('users');
        $users[] = [
            'id' => $this->storage->nextId('users'),
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'student'
        ];
        $this->storage->set('users', $users);
        return true;
    }

    public function update(int $id, array $data): bool {
        $users = $this->storage->get('users');
        foreach ($users as &$user) {
            if ((int)$user['id'] !== $id) continue;
            $user['name'] = $data['name'];
            $user['username'] = $data['username'];
            if (!empty($data['password'])) $user['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->storage->set('users', $users);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        return $this->storage->remove('users', $id);
    }

    public function findByUsername(string $username): ?array {
        foreach ($this->storage->get('users') as $user) {
            if (strcasecmp($user['username'], $username) === 0) return $user;
        }
        return null;
    }

    public function find(int $id): ?array {
        foreach ($this->storage->get('users') as $user) {
            if ((int)$user['id'] === $id) return $user;
        }
        return null;
    }
}
?>