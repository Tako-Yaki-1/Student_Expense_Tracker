<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Edit Category"; $id=(int)($_GET['id']??0); $category=$categoryModel->find($id);
if(!$category){header("Location: categories.php");exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $categoryModel->update($id,['category_name'=>trim($_POST['category_name'])]);
    header("Location: categories.php");exit;
}
?>
<h1>Edit Category</h1><p class="subtitle">Update the category name.</p>
<div class="card form-card"><form method="post"><div class="field"><label>Category Name</label><input name="category_name" value="<?= e($category['category_name']) ?>" required></div><div class="actions"><a class="btn btn-secondary" href="categories.php">Cancel</a><button class="btn btn-primary">Save Changes</button></div></form></div>
<?php require_once "includes/footer.php"; ?>