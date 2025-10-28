<?php
require_once __DIR__.'/../includes/db.php';
require_once __DIR__.'/../includes/security.php';
session_start();
if(empty($_SESSION['user_id']) || $_SESSION['role']!=='student'){ header('Location:/auth/login.php'); exit; }
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT subject,score,grade,term,session,remark,date_uploaded FROM results WHERE student_id = ? ORDER BY date_uploaded DESC');
$stmt->execute([$uid]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><head><meta charset='utf-8'><title>Your Results</title><link rel='stylesheet' href='/public/style.css'></head><body>
<div class='container'><h2>Your Results</h2><p><a href='/student/dashboard.php'>Back</a> | <a href='/student/download_report.php'>Download PDF Report</a></p><div class='card'><?php if(empty($rows)): ?><p>No results yet.</p><?php else: ?><table class='table'><thead><tr><th>Subject</th><th>Score</th><th>Grade</th><th>Term</th><th>Session</th><th>Remark</th><th>Date</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?=htmlspecialchars($r['subject'])?></td><td><?=htmlspecialchars($r['score'])?></td><td><?=htmlspecialchars($r['grade'])?></td><td><?=htmlspecialchars($r['term'])?></td><td><?=htmlspecialchars($r['session'])?></td><td><?=htmlspecialchars($r['remark'])?></td><td><?=htmlspecialchars($r['date_uploaded'])?></td></tr><?php endforeach; ?></tbody></table><?php endif; ?></div></div></body></html>
