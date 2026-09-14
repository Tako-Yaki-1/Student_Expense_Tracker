<?php
session_start();

require_once __DIR__ . '/../config/Storage.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Expense.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$storage = new Storage(__DIR__ . '/../data/data.json');
$userModel = new User($storage);
$expenseModel = new Expense($storage);
$categoryModel = new Category($storage);

function requireLogin(): void {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
function money(float $value): string {
    return '₱' . number_format($value, 2);
}
?>