<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Reports"; $cats=$expenseModel->byCategory($_SESSION['user_id']); $total=$expenseModel->total($_SESSION['user_id']);
$max=1; foreach($cats as $c) $max=max($max,(float)$c['total']);
?>
<h1>Reports</h1><p class="subtitle">View your spending insights.</p>
<div class="cards"><div class="card"><div class="label">Total Expenses</div><div class="metric"><?= money($total) ?></div></div><div class="card"><div class="label">Top Category</div><div class="metric" style="font-size:18px"><?= e($cats[0]['category_name']??'None') ?></div></div></div>
<div class="report-grid"><div class="card"><h3>Expenses by Category</h3><?php foreach($cats as $c): ?><div class="bar"><span><?= e($c['category_name']) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= ($c['total']/$max)*100 ?>%"></div></div><span class="amount"><?= money((float)$c['total']) ?></span></div><?php endforeach; ?></div>
<div class="card"><h3>Spending Summary</h3><p class="stats-note">Use the category totals to identify where most of your money is going. Add more expenses to make your report more useful.</p><div class="actions" style="justify-content:flex-start"><a class="btn btn-primary" href="add-expense.php">Add Expense</a></div></div></div>
<?php require_once "includes/footer.php"; ?>