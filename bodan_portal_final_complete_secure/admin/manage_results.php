<?php require_once '../config.php'; if(!is_admin()) { redirect('login.php'); } ?>
<?php
require_once '../config.php';
$search = esc($_GET['q'] ?? '');
$where = [];
if($search) $where[] = "(student_email LIKE '%$search%' OR subject LIKE '%$search%' OR teacher_email LIKE '%$search%')";
$q = "SELECT * FROM results" . (count($where)? ' WHERE '.implode(' AND ',$where) : '') . " ORDER BY date_uploaded DESC";
$res = $conn->query($q);
?>
<!doctype html><html><head><title>Manage Results</title><link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container">
  <h1>All Results</h1>
  <form method="get"><input name="q" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>"><button>Search</button></form>
  <table class="table">
    <thead><tr><th>#</th><th>Student</th><th>Subject</th><th>Score</th><th>Grade</th><th>Teacher</th><th>Term</th><th>Session</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
    <?php $i=1; while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($r['student_email']); ?></td>
        <td><?php echo htmlspecialchars($r['subject']); ?></td>
        <td><?php echo htmlspecialchars($r['score']); ?></td>
        <td><?php echo htmlspecialchars($r['grade']); ?></td>
        <td><?php echo htmlspecialchars($r['teacher_email']); ?></td>
        <td><?php echo htmlspecialchars($r['term']); ?></td>
        <td><?php echo htmlspecialchars($r['session']); ?></td>
        <td><?php echo $r['date_uploaded']; ?></td>
        <td>
          <a href="edit_result.php?id=<?php echo $r['id']; ?>">Edit</a> |
          <a href="delete_result.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body></html>