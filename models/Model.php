<?php
abstract class Model {
    protected PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    abstract public function create(array $data): bool;
    abstract public function update(int $id, array $data): bool;
    abstract public function delete(int $id): bool;
}
?>