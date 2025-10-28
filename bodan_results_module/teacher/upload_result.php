<?php
require_once __DIR__.'/../includes/db.php';
require_once __DIR__.'/../includes/security.php';
session_start();
if(empty($_SESSION['user_id']) || $_SESSION['role']!=='teacher'){ header('Location:/auth/login.php'); exit; }

function calculate_grade($score){
    if($score >= 70) return 'A';
    if($score >= 60) return 'B';
    if($score >= 50) return 'C';
    if($score >= 45) return 'D';
    return 'F';
}

$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $student_email = trim($_POST['student_email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $score = intval($_POST['score'] ?? 0);
    $term = trim($_POST['term'] ?? '');
    $session = trim($_POST['session'] ?? '');
    $remark = trim($_POST['remark'] ?? '');

    if(!$student_email || !$subject || $score<0){ $message = 'Please fill required fields'; }
    else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND role = "student" LIMIT 1');
        $stmt->execute([$student_email]);
        $s = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$s){ $message = 'Student not found'; }
        else {
            $grade = calculate_grade($score);
            $teacher_id = $_SESSION['user_id'];
            $stmt = $pdo->prepare('INSERT INTO results (student_id,subject,score,grade,term,session,remark,teacher_id) VALUES (?,?,?,?,?,?,?,?)');
            $stmt->execute([$s['id'],$subject,$score,$grade,$term,$session,$remark,$teacher_id]);
            $message = 'Result uploaded: ' . htmlspecialchars($subject) . ' - ' . $score . ' (' . $grade . ')';
        }
    }
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Upload Result</title><link rel='stylesheet' href='/public/style.css'></head><body>
<div class='container' style='max-width:720px;margin-top:24px'>
  <h2>Upload Result</h2>
  <p><a href='/teacher/dashboard.php'>Back to Dashboard</a></p>
  <?php if($message): ?><div class='card'><p><?=htmlspecialchars($message)?></p></div><?php endif; ?>
  <form method='post' class='card'>
    <label>Student Email (student@example.com)</label>
    <input type='email' name='student_email' required>
    <label>Subject</label>
    <input name='subject' required>
    <label>Score (0-100)</label>
    <input type='number' name='score' min='0' max='100' required>
    <label>Term (e.g. First Term)</label>
    <input name='term' required>
    <label>Session (e.g. 2024/2025)</label>
    <input name='session' required>
    <label>Remark (optional)</label>
    <textarea name='remark'></textarea>
    <button type='submit'>Upload Result</button>
  </form>
</div>
</body></html>
