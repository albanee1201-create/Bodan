<?php require_once '../config.php'; if(!is_student()) { redirect('login.php'); } ?>
<?php
require_once '../config.php';
$student_email = esc($_GET['email'] ?? '');
if (!$student_email) die('Student email required (for demo use: ?email=student@example.com)');
$res = $conn->query("SELECT * FROM results WHERE student_email='".$student_email."' ORDER BY date_uploaded DESC");
?>
<!doctype html><html><head><title>My Results</title><link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container">
  <h1>Results for <?php echo htmlspecialchars($student_email); ?></h1>
  <table class="table">
    <thead><tr><th>Subject</th><th>Score</th><th>Grade</th><th>Term</th><th>Session</th><th>Remark</th></tr></thead>
    <tbody>
      <?php while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['subject']); ?></td>
        <td><?php echo htmlspecialchars($r['score']); ?></td>
        <td><?php echo htmlspecialchars($r['grade']); ?></td>
        <td><?php echo htmlspecialchars($r['term']); ?></td>
        <td><?php echo htmlspecialchars($r['session']); ?></td>
        <td><?php echo htmlspecialchars($r['remark']); ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a class="btn" href="download_report.php?email=<?php echo urlencode($student_email); ?>">Download Report Card (PDF)</a>
</div>
</body></html>
