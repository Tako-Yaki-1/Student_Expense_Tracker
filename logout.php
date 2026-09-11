<?php
require_once "includes/bootstrap.php";
$auth = new AuthController($userModel);
$auth->logout();
header("Location: login.php");
exit;
?>