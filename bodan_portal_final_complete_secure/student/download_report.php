<?php require_once '../config.php'; if(!is_student()) { redirect('login.php'); } ?>
<?php
require_once '../config.php';
$email = esc($_GET['email'] ?? '');
if(!$email) die('Email required');
$res = $conn->query("SELECT * FROM results WHERE student_email='".$email."' ORDER BY subject");

// fallback HTML to print or save as PDF
?>
<!doctype html><html><head><meta charset="utf-8"><title>Report Card</title>
<link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container">
  <h1>Report Card</h1>
  <p>Student: <?php echo htmlspecialchars($email); ?></p>
  <table class="table">
    <thead><tr><th>Subject</th><th>Score</th><th>Grade</th><th>Remark</th></tr></thead>
    <tbody>
    <?php while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['subject']); ?></td>
        <td><?php echo htmlspecialchars($r['score']); ?></td>
        <td><?php echo htmlspecialchars($r['grade']); ?></td>
        <td><?php echo htmlspecialchars($r['remark']); ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  <p>Principal's Signature: _______________________</p>
  <p><button onclick="window.print()">Print / Save as PDF</button></p>
</div>
</body></html>
