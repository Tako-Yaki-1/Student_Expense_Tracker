<?php
class Storage {
    private string $file;

    public function __construct(string $file) {
        $this->file = $file;
        if (!is_file($file)) {
            $this->setData(['users' => [], 'categories' => [], 'expenses' => []]);
        }
    }

    public function get(string $collection): array {
        $data = $this->read();
        return $data[$collection] ?? [];
    }

    public function set(string $collection, array $records): void {
        $data = $this->read();
        $data[$collection] = array_values($records);
        $this->setData($data);
    }

    public function nextId(string $collection): int {
        $ids = array_column($this->get($collection), 'id');
        return $ids ? max(array_map('intval', $ids)) + 1 : 1;
    }

    public function remove(string $collection, int $id): bool {
        $records = $this->get($collection);
        $remaining = array_filter($records, fn(array $record): bool => (int)$record['id'] !== $id);
        if (count($remaining) === count($records)) return false;
        $this->set($collection, $remaining);
        return true;
    }

    private function read(): array {
        $contents = is_file($this->file) ? file_get_contents($this->file) : false;
        $data = $contents ? json_decode($contents, true) : null;
        return is_array($data) ? $data : ['users' => [], 'categories' => [], 'expenses' => []];
    }

    private function setData(array $data): void {
        $directory = dirname($this->file);
        if (!is_dir($directory)) mkdir($directory, 0775, true);
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    }
}
?>
