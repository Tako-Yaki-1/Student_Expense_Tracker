<?php
class Category extends Model {
    public function create(array $data): bool {
        $categories = $this->storage->get('categories');
        $categories[] = ['id' => $this->storage->nextId('categories'), 'category_name' => $data['category_name']];
        $this->storage->set('categories', $categories);
        return true;
    }

    public function update(int $id, array $data): bool {
        $categories = $this->storage->get('categories');
        foreach ($categories as &$category) {
            if ((int)$category['id'] !== $id) continue;
            $category['category_name'] = $data['category_name'];
            $this->storage->set('categories', $categories);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        foreach ($this->storage->get('expenses') as $expense) {
            if ((int)$expense['category_id'] === $id) return false;
        }
        return $this->storage->remove('categories', $id);
    }

    public function all(): array {
        $categories = $this->storage->get('categories');
        usort($categories, fn(array $a, array $b): int => strcasecmp($a['category_name'], $b['category_name']));
        return $categories;
    }

    public function find(int $id): ?array {
        foreach ($this->storage->get('categories') as $category) {
            if ((int)$category['id'] === $id) return $category;
        }
        return null;
    }
}
?>