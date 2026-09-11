<?php
require_once "includes/bootstrap.php"; requireLogin();
$id=(int)($_GET['id']??0);
try { $categoryModel->delete($id); } catch(PDOException $e) {}
header("Location: categories.php"); exit;
?>