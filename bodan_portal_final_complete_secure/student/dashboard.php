<?php require_once '../config.php'; if(!is_student()) redirect('login.php'); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Student Dashboard</title><link rel='stylesheet' href='../assets/css/styles.css'></head><body>
<div class='container'>
  <h1>Student Dashboard</h1>
  <p>Welcome, <?php echo htmlspecialchars(current_user_email()); ?></p>
  <ul>
    <li><a href='view_results.php?email=<?php echo urlencode(current_user_email()); ?>'>View Results</a></li>
    <li><a href='../payment/pay.php'>Make Payment</a></li>
    <li><a href='download_report.php?email=<?php echo urlencode(current_user_email()); ?>'>Download Report</a></li>
    <li><a href='logout.php'>Logout</a></li>
  </ul>
</div></body></html>