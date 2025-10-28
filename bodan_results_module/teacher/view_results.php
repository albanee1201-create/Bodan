<?php
require_once __DIR__.'/../includes/db.php';
require_once __DIR__.'/../includes/security.php';
session_start();
if(empty($_SESSION['user_id']) || $_SESSION['role']!=='teacher'){ header('Location:/auth/login.php'); exit; }

$results = $pdo->prepare('SELECT r.*, u.name AS student_name, u.email AS student_email FROM results r JOIN users u ON r.student_id = u.id WHERE r.teacher_id = ? ORDER BY r.date_uploaded DESC');
$results->execute([$_SESSION['user_id']]);
$rows = $results->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><head><meta charset='utf-8'><title>View Uploaded Results</title><link rel='stylesheet' href='/public/style.css'></head><body>
<div class='container'><h2>Your Uploaded Results</h2><p><a href='/teacher/dashboard.php'>Back</a></p><div class='card'><table class='table'><thead><tr><th>#</th><th>Student</th><th>Subject</th><th>Score</th><th>Grade</th><th>Term</th><th>Session</th><th>Date</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?=htmlspecialchars($r['id'])?></td><td><?=htmlspecialchars($r['student_name'])?> (<?=htmlspecialchars($r['student_email'])?>)</td><td><?=htmlspecialchars($r['subject'])?></td><td><?=htmlspecialchars($r['score'])?></td><td><?=htmlspecialchars($r['grade'])?></td><td><?=htmlspecialchars($r['term'])?></td><td><?=htmlspecialchars($r['session'])?></td><td><?=htmlspecialchars($r['date_uploaded'])?></td></tr><?php endforeach; ?></tbody></table></div></div></body></html>
