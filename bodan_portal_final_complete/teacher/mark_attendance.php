<?php
require_once '../config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $student_email = esc($_POST['student_email']);
  $class = esc($_POST['class']);
  $date = esc($_POST['date']);
  $status = esc($_POST['status']);
  $teacher = esc($_POST['teacher_email']);
  $stmt = $conn->prepare("INSERT INTO attendance (student_email, class, date, status, marked_by) VALUES (?,?,?,?,?)");
  $stmt->bind_param('sssss',$student_email,$class,$date,$status,$teacher);
  if($stmt->execute()) echo 'ok'; else echo 'error: '.$stmt->error;
  exit;
}
?>