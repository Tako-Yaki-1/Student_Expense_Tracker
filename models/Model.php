<?php
abstract class Model {
    protected Storage $storage;

    public function __construct(Storage $storage) {
        $this->storage = $storage;
    }

    abstract public function create(array $data): bool;
    abstract public function update(int $id, array $data): bool;
    abstract public function delete(int $id): bool;
}
?>