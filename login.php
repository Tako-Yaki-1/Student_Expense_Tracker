<?php
require_once "includes/bootstrap.php";
if (isset($_SESSION['user_id'])) { header("Location: dashboard.php"); exit; }

$error = '';
$registered = isset($_GET['registered']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController($userModel);
    if ($auth->login(trim($_POST['username'] ?? ''), $_POST['password'] ?? '')) {
        header("Location: dashboard.php"); exit;
    }
    $error = "Invalid username or password.";
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - Expense Tracker</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<div class="auth">
<div class="auth-art"><div><h1>Track Your Expenses.<br>Build a Better Tomorrow.</h1><p>Small steps today, better money habits tomorrow.</p></div></div>
<div class="auth-box"><form class="auth-form" method="post">
<h2>Student Expense Tracker</h2><p class="subtitle center">Log in to your account</p>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<?php if($registered): ?><div class="notice">Account created. You can log in now.</div><?php endif; ?>
<div class="field"><label>Username</label><input name="username" required placeholder="Enter username"></div>
<div class="field"><label>Password</label><input type="password" name="password" required placeholder="Enter password"></div>
<label style="font-size:12px"><input type="checkbox"> Remember me</label>
<div class="actions"><button class="btn btn-primary" style="width:100%">Login</button></div>
<p class="center" style="font-size:12px">Don't have an account? <a href="register.php">Register</a></p>
</form></div></div></body></html>