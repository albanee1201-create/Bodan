<?php
// install_seed.php - run once to create a secure admin using password_hash()
require_once 'config.php';

$admin_email = 'admin@bodan.edu';
$admin_pass = 'admin123'; // CHANGE THIS AFTER RUNNING
$admin_name = 'Super Admin';

// check if admin exists
$stmt = $conn->prepare('SELECT id FROM admins WHERE email=?');
$stmt->bind_param('s', $admin_email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){
    echo 'Admin already exists. Delete existing admin if you want to recreate.';
    exit;
}
$password_hash = password_hash($admin_pass, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO admins (name, email, password) VALUES (?,?,?)');
$stmt->bind_param('sss', $admin_name, $admin_email, $password_hash);
if ($stmt->execute()){
    echo 'Admin created: ' . $admin_email . ' with password: ' . $admin_pass . '\n';
    echo 'IMPORTANT: Delete this file (install_seed.php) after use and change the password immediately.';
} else {
    echo 'Error: ' . $stmt->error;
}
?>