<?php
require_once '../config.php';
if (is_admin()) redirect('dashboard.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = esc($_POST['email']);
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT password FROM admins WHERE email=? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            login_user($email, 'admin');
            redirect('dashboard.php');
        } else $error = 'Invalid credentials';
    } else $error = 'Invalid credentials';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Login</title><link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container"><h1>Admin Login</h1><?php if($error) echo '<p class="err">'.htmlspecialchars($error).'</p>'; ?>
<form method="post">
<label>Email</label><input type="email" name="email" required>
<label>Password</label><input type="password" name="password" required>
<button class="btn">Login</button>
</form></div></body></html>
