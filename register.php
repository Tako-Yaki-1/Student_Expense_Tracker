<?php
require_once "includes/bootstrap.php";
if (isset($_SESSION['user_id'])) { header("Location: dashboard.php"); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name=trim($_POST['name']??''); $username=trim($_POST['username']??'');
    $password=$_POST['password']??''; $confirm=$_POST['confirm_password']??'';
    if ($name === '' || $username === '') $error='Please complete all required fields.';
    elseif ($password === '' || $password !== $confirm) $error='Passwords do not match.';
    elseif ($userModel->findByUsername($username)) $error='Username already exists.';
    else {
        $userModel->create(['name'=>$name,'username'=>$username,'password'=>$password,'role'=>'student']);
        header("Location: login.php?registered=1"); exit;
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title><link rel="stylesheet" href="assets/style.css"></head>
<body><div class="auth"><div class="auth-art"><div><h1>Better Money Habits, Brighter Future.</h1><p>Create your account and start tracking your spending.</p></div></div>
<div class="auth-box"><form class="auth-form" method="post"><h2>Create Account</h2><p class="subtitle center">Register as a student</p>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<div class="field"><label>Full Name</label><input name="name" required></div>
<div class="field"><label>Username</label><input name="username" required></div>
<div class="field"><label>Password</label><input type="password" name="password" required></div>
<div class="field"><label>Confirm Password</label><input type="password" name="confirm_password" required></div>
<button class="btn btn-primary" style="width:100%">Register</button>
<p class="center" style="font-size:12px">Already have an account? <a href="login.php">Login</a></p>
</form></div></div></body></html>