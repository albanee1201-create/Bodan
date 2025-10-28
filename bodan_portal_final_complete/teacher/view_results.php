<?php
require_once '../config.php';
$teacher = esc($_GET['teacher'] ?? '');
$term = esc($_GET['term'] ?? '');
$subject = esc($_GET['subject'] ?? '');
$where = [];
if ($teacher) $where[] = "teacher_email='".$teacher."'";
if ($term) $where[] = "term='".$term."'";
if ($subject) $where[] = "subject='".$subject."'";
$q = "SELECT * FROM results" . (count($where)? ' WHERE '.implode(' AND ',$where) : '') . " ORDER BY date_uploaded DESC";
$res = $conn->query($q);
?>
<!doctype html><html><head><title>My Uploaded Results</title><link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container">
  <h1>My Results</h1>
  <form method="get">
    <label>Teacher Email</label><input name="teacher" value="<?php echo htmlspecialchars($teacher); ?>">
    <label>Subject</label><input name="subject" value="<?php echo htmlspecialchars($subject); ?>">
    <label>Term</label><input name="term" value="<?php echo htmlspecialchars($term); ?>">
    <button>Filter</button>
  </form>
  <table class="table">
    <thead><tr><th>#</th><th>Student</th><th>Subject</th><th>Score</th><th>Grade</th><th>Term</th><th>Session</th><th>Remark</th><th>Date</th></tr></thead>
    <tbody>
      <?php $i=1; while($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo htmlspecialchars($r['student_email']); ?></td>
          <td><?php echo htmlspecialchars($r['subject']); ?></td>
          <td><?php echo htmlspecialchars($r['score']); ?></td>
          <td><?php echo htmlspecialchars($r['grade']); ?></td>
          <td><?php echo htmlspecialchars($r['term']); ?></td>
          <td><?php echo htmlspecialchars($r['session']); ?></td>
          <td><?php echo htmlspecialchars($r['remark']); ?></td>
          <td><?php echo $r['date_uploaded']; ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div></body></html>
