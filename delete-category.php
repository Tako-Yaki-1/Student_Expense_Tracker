<?php
require_once "includes/bootstrap.php"; requireLogin();
$id=(int)($_GET['id']??0);
$categoryModel->delete($id);
header("Location: categories.php"); exit;
?>