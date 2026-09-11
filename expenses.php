<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Expenses"; $categories=$categoryModel->all();
$search=trim($_GET['search']??''); $category=$_GET['category']??'';
$expenses=$expenseModel->allByUser($_SESSION['user_id'],$search,$category);
?>
<h1>Expenses</h1><p class="subtitle">Here are all your recorded expenses.</p>
<div class="toolbar"><form class="filters" method="get"><input name="search" value="<?= e($search) ?>" placeholder="Search expenses..."><select name="category"><option value="">All Categories</option><?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>" <?= $category==$c['id']?'selected':'' ?>><?= e($c['category_name']) ?></option><?php endforeach; ?></select><button class="btn btn-secondary" type="submit">Filter</button><?php if($search !== '' || $category !== ''): ?><a class="btn btn-secondary" href="expenses.php">Reset</a><?php endif; ?></form><a class="btn btn-primary" href="add-expense.php">＋ Add Expense</a></div>
<div class="card table-card"><table class="table"><thead><tr><th>ID</th><th>Description</th><th>Category</th><th>Amount</th><th>Date</th><th>Actions</th></tr></thead><tbody>
<?php if(!$expenses): ?><tr><td colspan="6" class="empty">No expenses found.</td></tr><?php endif; ?>
<?php foreach($expenses as $x): ?><tr><td><?= $x['id'] ?></td><td><?= e($x['description']) ?></td><td><span class="badge"><?= e($x['category_name']) ?></span></td><td><?= money((float)$x['amount']) ?></td><td><?= date('M d, Y',strtotime($x['expense_date'])) ?></td><td class="actions-cell"><a class="btn btn-small btn-secondary" href="edit-expense.php?id=<?= $x['id'] ?>">Edit</a><a class="btn btn-small btn-danger" onclick="return confirm('Delete this expense?')" href="delete-expense.php?id=<?= $x['id'] ?>">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div>
<?php require_once "includes/footer.php"; ?>