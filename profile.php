<?php
require_once "includes/header.php"; requireLogin();
$pageTitle="Profile"; $user=$userModel->find($_SESSION['user_id']); $message=''; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $action=$_POST['action']??'';
    if($action==='profile'){
        $userModel->update($_SESSION['user_id'],['name'=>trim($_POST['name']),'username'=>trim($_POST['username'])]);
        $_SESSION['name']=trim($_POST['name']); $message='Profile updated successfully.';
    } elseif($action==='password'){
        if($_POST['password']!==$_POST['confirm_password']) $error='Passwords do not match.';
        else { $userModel->update($_SESSION['user_id'],['name'=>$user['name'],'username'=>$user['username'],'password'=>$_POST['password']]); $message='Password changed successfully.'; }
    }
    $user=$userModel->find($_SESSION['user_id']);
}
?>
<h1>Profile</h1><p class="subtitle">Manage your account information.</p>
<?php if($message): ?><div class="card" style="margin-bottom:15px"><?= e($message) ?></div><?php endif; ?><?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<div class="card profile"><div><div class="profile-avatar"><?= e(strtoupper(substr($user['name'],0,1))) ?></div><p class="center"><b><?= e($user['name']) ?></b><br><span class="stats-note"><?= e($user['role']) ?></span></p></div>
<div><h3>Account Information</h3><form method="post"><input type="hidden" name="action" value="profile"><div class="form-grid"><div class="field"><label>Full Name</label><input name="name" value="<?= e($user['name']) ?>" required></div><div class="field"><label>Username</label><input name="username" value="<?= e($user['username']) ?>" required></div></div><div class="actions"><button class="btn btn-primary">Update Profile</button></div></form>
<hr style="border:0;border-top:1px solid #edf2f0;margin:25px 0"><h3>Change Password</h3><form method="post"><input type="hidden" name="action" value="password"><div class="form-grid"><div class="field"><label>New Password</label><input type="password" name="password" required></div><div class="field"><label>Confirm New Password</label><input type="password" name="confirm_password" required></div></div><div class="actions"><button class="btn btn-primary">Change Password</button></div></form></div></div>
<?php require_once "includes/footer.php"; ?>