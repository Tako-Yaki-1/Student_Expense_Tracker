<?php require_once __DIR__ . '/bootstrap.php'; ?>
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle ?? 'Expense Tracker') ?></title>
<link rel="stylesheet" href="assets/style.css">
<link rel="stylesheet" href="assets/account-menu.css">
</head>
<body>
<div class="app">
<aside class="sidebar">
    <div class="brand"><span class="brand-icon">▣</span><span>Expense<br>Tracker</span></div>
    <nav>
        <a class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">⌂ <span>Dashboard</span></a>
        <a class="<?= $currentPage === 'add-expense.php' ? 'active' : '' ?>" href="add-expense.php">＋ <span>Add Expense</span></a>
        <a class="<?= in_array($currentPage, ['expenses.php', 'edit-expense.php', 'delete-expense.php'], true) ? 'active' : '' ?>" href="expenses.php">▤ <span>Expenses</span></a>
        <a class="<?= in_array($currentPage, ['categories.php', 'edit-category.php', 'delete-category.php'], true) ? 'active' : '' ?>" href="categories.php">◈ <span>Categories</span></a>
        <a class="<?= $currentPage === 'reports.php' ? 'active' : '' ?>" href="reports.php">◒ <span>Reports</span></a>
        <a class="<?= $currentPage === 'profile.php' ? 'active' : '' ?>" href="profile.php">⚙ <span>Settings</span></a>
    </nav>
    <a class="logout" href="logout.php">⇥ Logout</a>
</aside>
<main class="main">
<header class="topbar">
    <div class="mobile-brand">Expense Tracker</div>
    <div class="top-actions">
        <details class="account-menu">
            <summary class="user-menu" title="Open account menu">
                <span class="avatar"><?= e(strtoupper(substr($_SESSION['name'] ?? 'U',0,1))) ?></span>
                <span><?= e($_SESSION['name'] ?? '') ?></span>
                <span class="user-chevron">▾</span>
            </summary>
            <div class="account-dropdown">
                <div class="account-heading"><span class="account-label">Signed in as</span><strong><?= e($_SESSION['name'] ?? '') ?></strong></div>
                <a href="dashboard.php">⌂ <span>Dashboard</span></a>
                <a href="profile.php">⚙ <span>Profile settings</span></a>
                <a class="account-logout" href="logout.php">⇥ <span>Logout</span></a>
            </div>
        </details>
    </div>
</header>
<section class="content">
