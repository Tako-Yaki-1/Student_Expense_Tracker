<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Edit Expense"; $categories=$categoryModel->all(); $id=(int)($_GET['id']??0);
$expense=$expenseModel->find($id,$_SESSION['user_id']);
if(!$expense){header("Location: expenses.php");exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $amount=(float)($_POST['amount']??0);
    if($amount<=0 || empty($_POST['description']) || empty($_POST['category_id']) || empty($_POST['expense_date'])) $error='Please complete all required fields.';
    else {
        $expenseModel->update($id,['user_id'=>$_SESSION['user_id'],'category_id'=>(int)$_POST['category_id'],'description'=>trim($_POST['description']),'amount'=>$amount,'expense_date'=>$_POST['expense_date'],'notes'=>trim($_POST['notes']??'')]);
        header("Location: expenses.php");exit;
    }
}
?>
<h1>Edit Expense</h1><p class="subtitle">Update the details of your expense.</p>
<div class="card form-card"><?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post"><div class="form-grid">
<div class="field full"><label>Description *</label><input name="description" value="<?= e($expense['description']) ?>" required></div>
<div class="field"><label>Amount *</label><input type="number" step="0.01" min="0.01" name="amount" value="<?= e((string)$expense['amount']) ?>" required></div>
<div class="field"><label>Date *</label><input type="date" name="expense_date" value="<?= e($expense['expense_date']) ?>" required></div>
<div class="field"><label>Category *</label><select name="category_id" required><?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>" <?= $expense['category_id']==$c['id']?'selected':'' ?>><?= e($c['category_name']) ?></option><?php endforeach; ?></select></div>
<div class="field"><label>Notes (Optional)</label><textarea name="notes"><?= e($expense['notes']??'') ?></textarea></div>
</div><div class="actions"><a class="btn btn-secondary" href="expenses.php">Cancel</a><button class="btn btn-primary">Update Expense</button></div></form></div>
<?php require_once "includes/footer.php"; ?>