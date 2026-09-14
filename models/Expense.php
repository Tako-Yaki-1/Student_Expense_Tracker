<?php
class Expense extends Model {
    public function create(array $data): bool {
        $expenses = $this->storage->get('expenses');
        $expenses[] = [
            'id' => $this->storage->nextId('expenses'),
            'user_id' => (int)$data['user_id'],
            'category_id' => (int)$data['category_id'],
            'description' => $data['description'],
            'amount' => (float)$data['amount'],
            'expense_date' => $data['expense_date'],
            'notes' => $data['notes'] ?? ''
        ];
        $this->storage->set('expenses', $expenses);
        return true;
    }

    public function update(int $id, array $data): bool {
        $expenses = $this->storage->get('expenses');
        foreach ($expenses as &$expense) {
            if ((int)$expense['id'] !== $id || (int)$expense['user_id'] !== (int)$data['user_id']) continue;
            $expense['category_id'] = (int)$data['category_id'];
            $expense['description'] = $data['description'];
            $expense['amount'] = (float)$data['amount'];
            $expense['expense_date'] = $data['expense_date'];
            $expense['notes'] = $data['notes'] ?? '';
            $this->storage->set('expenses', $expenses);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        return $this->storage->remove('expenses', $id);
    }

    public function allByUser(int $userId, string $search = '', string $category = ''): array {
        $categories = $this->categoryNames();
        $expenses = array_filter($this->storage->get('expenses'), function (array $expense) use ($userId, $search, $category): bool {
            return (int)$expense['user_id'] === $userId
                && ($search === '' || stripos($expense['description'], $search) !== false)
                && ($category === '' || (int)$expense['category_id'] === (int)$category);
        });
        foreach ($expenses as &$expense) $expense['category_name'] = $categories[(int)$expense['category_id']] ?? 'Uncategorized';
        usort($expenses, fn(array $a, array $b): int => strcmp($b['expense_date'] . sprintf('%08d', $b['id']), $a['expense_date'] . sprintf('%08d', $a['id'])));
        return array_values($expenses);
    }

    public function find(int $id, int $userId): ?array {
        foreach ($this->storage->get('expenses') as $expense) {
            if ((int)$expense['id'] === $id && (int)$expense['user_id'] === $userId) return $expense;
        }
        return null;
    }

    public function total(int $userId): float {
        return $this->sum($userId, fn(array $expense): bool => true);
    }

    public function thisMonth(int $userId): float {
        $month = date('Y-m');
        return $this->sum($userId, fn(array $expense): bool => str_starts_with($expense['expense_date'], $month));
    }

    public function today(int $userId): float {
        $today = date('Y-m-d');
        return $this->sum($userId, fn(array $expense): bool => $expense['expense_date'] === $today);
    }

    public function count(int $userId): int {
        return count(array_filter($this->storage->get('expenses'), fn(array $expense): bool => (int)$expense['user_id'] === $userId));
    }

    public function byCategory(int $userId): array {
        $totals = [];
        foreach ($this->storage->get('categories') as $category) $totals[(int)$category['id']] = ['category_name' => $category['category_name'], 'total' => 0.0];
        foreach ($this->storage->get('expenses') as $expense) {
            if ((int)$expense['user_id'] === $userId && isset($totals[(int)$expense['category_id']])) $totals[(int)$expense['category_id']]['total'] += (float)$expense['amount'];
        }
        $totals = array_values($totals);
        usort($totals, fn(array $a, array $b): int => $b['total'] <=> $a['total']);
        return $totals;
    }

    private function sum(int $userId, callable $matches): float {
        $total = 0.0;
        foreach ($this->storage->get('expenses') as $expense) if ((int)$expense['user_id'] === $userId && $matches($expense)) $total += (float)$expense['amount'];
        return $total;
    }

    private function categoryNames(): array {
        $names = [];
        foreach ($this->storage->get('categories') as $category) $names[(int)$category['id']] = $category['category_name'];
        return $names;
    }
}
?>