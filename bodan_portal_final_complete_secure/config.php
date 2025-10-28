<?php
// config.php - database & Paystack config (updated for secure auth)
session_start();

// ====== MySQL connection ======
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'bodan_portal_db';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}
$conn->set_charset('utf8');

// ====== Paystack keys (replace with your own) ======
// Use your Paystack TEST keys here for testing. Replace with live keys when ready.
define('PAYSTACK_SECRET_KEY', 'sk_test_REPLACE_WITH_YOURS');
define('PAYSTACK_PUBLIC_KEY', 'pk_test_REPLACE_WITH_YOURS');

// Base URL (adjust if in subfolder)
define('BASE_URL', '/');

// Helper: escape
function esc($s){ global $conn; return htmlspecialchars($conn->real_escape_string(trim($s))); }

// Auth helpers
function login_user($email, $role){
    // sets session role and email
    $_SESSION['role'] = $role;
    $_SESSION['email'] = $email;
}

function logout_user(){
    session_unset();
    session_destroy();
    session_start();
}

function current_user_email(){ return $_SESSION['email'] ?? null; }
function current_user_role(){ return $_SESSION['role'] ?? null; }
function is_admin(){ return current_user_role() === 'admin'; }
function is_teacher(){ return current_user_role() === 'teacher'; }
function is_student(){ return current_user_role() === 'student'; }

// Simple redirect helper
function redirect($url){ header('Location: '.$url); exit; }

?>