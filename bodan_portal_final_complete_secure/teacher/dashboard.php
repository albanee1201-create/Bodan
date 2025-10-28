<?php require_once '../config.php'; if(!is_teacher()) redirect('login.php'); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Teacher Dashboard</title><link rel='stylesheet' href='../assets/css/styles.css'></head><body>
<div class='container'>
  <h1>Teacher Dashboard</h1>
  <p>Welcome, <?php echo htmlspecialchars(current_user_email()); ?></p>
  <ul>
    <li><a href='upload_result.php'>Upload Result</a></li>
    <li><a href='upload_results_csv.php'>Upload Results CSV</a></li>
    <li><a href='view_results.php'>View My Results</a></li>
    <li><a href='mark_attendance.php'>Mark Attendance</a></li>
    <li><a href='logout.php'>Logout</a></li>
  </ul>
</div></body></html>