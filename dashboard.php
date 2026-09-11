<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Dashboard";
$total=$expenseModel->total($_SESSION['user_id']);
$month=$expenseModel->thisMonth($_SESSION['user_id']);
$today=$expenseModel->today($_SESSION['user_id']);
$count=$expenseModel->count($_SESSION['user_id']);
$cats=$expenseModel->byCategory($_SESSION['user_id']);
$max=1; foreach($cats as $c) $max=max($max,(float)$c['total']);
?>
<h1>Dashboard</h1><p class="subtitle">Here's your expense summary.</p>
<div class="cards">
<div class="card"><div class="icon">₱</div><div class="label">Total Expenses</div><div class="metric"><?= money($total) ?></div></div>
<div class="card"><div class="icon">▣</div><div class="label">This Month</div><div class="metric"><?= money($month) ?></div></div>
<div class="card"><div class="icon">◷</div><div class="label">Today's Expenses</div><div class="metric"><?= money($today) ?></div></div>
<div class="card"><div class="icon">#</div><div class="label">Number of Expenses</div><div class="metric"><?= $count ?></div></div>
</div>
<div class="grid2">
<div class="card"><h3>Expenses by Category</h3>
<?php foreach($cats as $c): ?><div class="bar"><span><?= e($c['category_name']) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= ($c['total']/$max)*100 ?>%"></div></div><span class="amount"><?= money((float)$c['total']) ?></span></div><?php endforeach; ?>
</div>
<div class="card"><h3>Quick Actions</h3><p class="stats-note">Record a new expense or review your spending.</p>
<div class="actions" style="justify-content:flex-start"><a class="btn btn-primary" href="add-expense.php">＋ Add Expense</a><a class="btn btn-secondary" href="expenses.php">View Expenses</a></div>
</div></div>
<?php require_once "includes/footer.php"; ?>