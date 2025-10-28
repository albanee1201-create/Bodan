<?php require_once '../config.php'; if(!is_admin()) redirect('login.php'); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Admin Dashboard</title><link rel='stylesheet' href='../assets/css/styles.css'></head><body>
<div class='container'>
  <h1>Admin Dashboard</h1>
  <p>Welcome, <?php echo htmlspecialchars(current_user_email()); ?></p>
  <ul>
    <li><a href='manage_students.php'>Manage Students</a></li>
    <li><a href='manage_teachers.php'>Manage Teachers</a></li>
    <li><a href='manage_results.php'>Manage Results</a></li>
    <li><a href='logout.php'>Logout</a></li>
  </ul>
</div></body></html>