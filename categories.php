<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Categories"; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['category_name']??'');
    if($name==='') $error='Category name is required.';
    else $categoryModel->create(['category_name'=>$name]);
}
$categories=$categoryModel->all();
?>
<h1>Categories</h1><p class="subtitle">Manage your expense categories.</p>
<div class="card form-card" style="margin-bottom:20px"><form method="post"><div class="form-grid"><div class="field"><label>New Category</label><input name="category_name" placeholder="e.g. Food" required></div><div class="actions" style="align-items:end"><button class="btn btn-primary">＋ Add Category</button></div></div></form></div>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<div class="card table-card"><table class="table"><thead><tr><th>ID</th><th>Category Name</th><th>Action</th></tr></thead><tbody>
<?php foreach($categories as $c): ?><tr><td><?= $c['id'] ?></td><td><?= e($c['category_name']) ?></td><td><a class="btn btn-small btn-secondary" href="edit-category.php?id=<?= $c['id'] ?>">Edit</a> <a class="btn btn-small btn-danger" onclick="return confirm('Delete this category? It may fail if expenses use it.')" href="delete-category.php?id=<?= $c['id'] ?>">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div>
<?php require_once "includes/footer.php"; ?>