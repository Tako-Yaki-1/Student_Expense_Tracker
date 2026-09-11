<?php
require_once "includes/bootstrap.php"; requireLogin();
$id=(int)($_GET['id']??0);
$expense=$expenseModel->find($id,$_SESSION['user_id']);
if($expense) $expenseModel->delete($id);
header("Location: expenses.php"); exit;
?>