<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $student_email = esc($_POST['student_email']);
    $subject = esc($_POST['subject']);
    $score = intval($_POST['score']);
    $term = esc($_POST['term']);
    $session = esc($_POST['session']);
    $remark = esc($_POST['remark']);
    $teacher_email = esc($_POST['teacher_email']);

    if ($score < 0 || $score > 100){ $err = 'Score must be between 0 and 100'; }
    else {
        if($score >= 70) $grade = 'A';
        elseif($score >= 60) $grade = 'B';
        elseif($score >= 50) $grade = 'C';
        elseif($score >= 45) $grade = 'D';
        elseif($score >= 40) $grade = 'E';
        else $grade = 'F';

        $stmt = $conn->prepare("INSERT INTO results (student_email, subject, score, grade, term, session, remark, teacher_email) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sisissss', $student_email, $subject, $score, $grade, $term, $session, $remark, $teacher_email);
        if($stmt->execute()) $msg = 'Result uploaded successfully ✅';
        else $err = 'DB error: '. $stmt->error;
    }
}
?>
<!doctype html><html><head><title>Upload Result</title><link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container">
  <h1>Upload Single Result</h1>
  <?php if(isset($err)) echo '<p class="err">'.$err.'</p>'; if(isset($msg)) echo '<p class="ok">'.$msg.'</p>'; ?>
  <form method="post">
    <label>Teacher Email</label>
    <input type="email" name="teacher_email" required>
    <label>Student Email</label>
    <input type="email" name="student_email" required>
    <label>Subject</label>
    <input type="text" name="subject" required>
    <label>Score (0-100)</label>
    <input type="number" min="0" max="100" name="score" required>
    <label>Term</label>
    <input type="text" name="term" required>
    <label>Session (e.g., 2024/2025)</label>
    <input type="text" name="session" required>
    <label>Remark</label>
    <textarea name="remark"></textarea>
    <button type="submit" class="btn">Upload Result</button>
  </form>
</div></body></html>
