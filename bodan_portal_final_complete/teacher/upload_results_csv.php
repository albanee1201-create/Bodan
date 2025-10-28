<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!isset($_FILES['csvfile'])){ $err='No file uploaded'; }
    else {
        $file = $_FILES['csvfile']['tmp_name'];
        $handle = fopen($file, 'r');
        $line = 0; $errors = []; $success = 0;
        while(($data = fgetcsv($handle)) !== FALSE){
            $line++;
            if($line == 1) continue; // skip header if present
            if(count($data) < 6){ $errors[] = "Line $line: incorrect columns"; continue; }
            $student_email = esc($data[0]);
            $subject = esc($data[1]);
            $score = intval($data[2]);
            $term = esc($data[3]);
            $session = esc($data[4]);
            $remark = esc($data[5]);
            if($score < 0 || $score > 100){ $errors[] = "Line $line: invalid score"; continue; }
            if($score >= 70) $grade = 'A';
            elseif($score >= 60) $grade = 'B';
            elseif($score >= 50) $grade = 'C';
            elseif($score >= 45) $grade = 'D';
            elseif($score >= 40) $grade = 'E';
            else $grade = 'F';
            $stmt = $conn->prepare("INSERT INTO results (student_email, subject, score, grade, term, session, remark, teacher_email) VALUES (?,?,?,?,?,?,?,?)");
            $teacher_email = esc($_POST['teacher_email']);
            $stmt->bind_param('sisissss', $student_email, $subject, $score, $grade, $term, $session, $remark, $teacher_email);
            if($stmt->execute()) $success++; else $errors[] = "Line $line: DB " . $stmt->error;
        }
        fclose($handle);
        $msg = "Imported: $success rows";
    }
}
?>
<!doctype html><html><head><title>CSV Upload</title><link rel="stylesheet" href="../assets/css/styles.css"></head><body>
<div class="container">
  <h1>Upload Results CSV</h1>
  <?php if(isset($err)) echo '<p class="err">'.$err.'</p>'; if(isset($msg)) echo '<p class="ok">'.$msg.'</p>'; ?>
  <form method="post" enctype="multipart/form-data">
    <label>Teacher Email</label>
    <input type="email" name="teacher_email" required>
    <label>CSV File (student_email,subject,score,term,session,remark)</label>
    <input type="file" name="csvfile" accept=".csv" required>
    <button type="submit" class="btn">Upload CSV</button>
  </form>
  <?php if(!empty($errors)){ echo '<h3>Errors</h3><ul>'; foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; echo '</ul>'; } ?>
</div></body></html>
