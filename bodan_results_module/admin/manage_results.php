<?php
require_once __DIR__.'/../includes/db.php';
require_once __DIR__.'/../includes/security.php';
session_start();
if(empty($_SESSION['user_id']) || $_SESSION['role']!=='admin'){ header('Location:/auth/login.php'); exit; }

$rows = $pdo->query('SELECT r.*, u.name AS student_name, t.name AS teacher_name FROM results r LEFT JOIN users u ON r.student_id=u.id LEFT JOIN users t ON r.teacher_id = t.id ORDER BY r.date_uploaded DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><head><meta charset='utf-8'><title>Manage Results</title><link rel='stylesheet' href='/public/style.css'></head><body>
<div class='container'><h2>All Results</h2><p><a href='/admin/dashboard.php'>Back</a></p><div class='card'><table class='table'><thead><tr><th>#</th><th>Student</th><th>Subject</th><th>Score</th><th>Grade</th><th>Term</th><th>Session</th><th>Teacher</th><th>Date</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?=htmlspecialchars($r['id'])?></td><td><?=htmlspecialchars($r['student_name'])?></td><td><?=htmlspecialchars($r['subject'])?></td><td><?=htmlspecialchars($r['score'])?></td><td><?=htmlspecialchars($r['grade'])?></td><td><?=htmlspecialchars($r['term'])?></td><td><?=htmlspecialchars($r['session'])?></td><td><?=htmlspecialchars($r['teacher_name'])?></td><td><?=htmlspecialchars($r['date_uploaded'])?></td></tr><?php endforeach; ?></tbody></table></div></div></body></html>
