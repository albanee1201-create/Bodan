<?php
require_once __DIR__.'/../includes/db.php';
require_once __DIR__.'/../includes/security.php';
session_start();
if(empty($_SESSION['user_id']) || $_SESSION['role']!=='teacher'){ header('Location:/auth/login.php'); exit; }
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['csvfile'])){
    $path = $_FILES['csvfile']['tmp_name'];
    if(($h = fopen($path,'r')) !== false){
        $rownum=0; $count=0;
        while(($row = fgetcsv($h,1000,',')) !== false){
            $rownum++; if($rownum==1) continue;
            $email = trim($row[0] ?? ''); $subject = trim($row[1] ?? ''); $score = intval($row[2] ?? 0); $term = trim($row[3] ?? ''); $session = trim($row[4] ?? ''); $remark = trim($row[5] ?? '');
            if(!$email || !$subject) continue;
            $st = $pdo->prepare('SELECT id FROM users WHERE email = ? AND role = "student" LIMIT 1');
            $st->execute([$email]); $u = $st->fetch(PDO::FETCH_ASSOC);
            if(!$u) continue;
            if($score>=70) $grade='A'; elseif($score>=60) $grade='B'; elseif($score>=50) $grade='C'; elseif($score>=45) $grade='D'; else $grade='F';
            $pdo->prepare('INSERT INTO results (student_id,subject,score,grade,term,session,remark,teacher_id) VALUES (?,?,?,?,?,?,?,?)')->execute([$u['id'],$subject,$score,$grade,$term,$session,$remark,$_SESSION['user_id']]);
            $count++;
        }
        fclose($h);
        $msg = 'Imported ' . $count . ' rows.';
    } else $msg='Unable to open file.';
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Bulk Upload Results</title><link rel='stylesheet' href='/public/style.css'></head><body>
<div class='container'><h2>Bulk Upload Results (CSV)</h2><p>CSV header: student_email,subject,score,term,session,remark</p><?php if($msg) echo '<div class="card"><p>'.htmlspecialchars($msg).'</p></div>'; ?><form method='post' enctype='multipart/form-data' class='card'><input type='file' name='csvfile' accept='.csv' required><button type='submit'>Upload CSV</button></form><p><a href='/teacher/dashboard.php'>Back to dashboard</a></p></div></body></html>
