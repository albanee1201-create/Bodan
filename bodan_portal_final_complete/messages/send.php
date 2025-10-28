<?php
require_once '../config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $sender = esc($_POST['sender_email']);
  $receiver = esc($_POST['receiver_email']);
  $subject = esc($_POST['subject']);
  $body = esc($_POST['body']);
  $stmt = $conn->prepare("INSERT INTO messages (sender_email, receiver_email, subject, body) VALUES (?,?,?,?)");
  $stmt->bind_param('ssss',$sender,$receiver,$subject,$body);
  if($stmt->execute()) echo 'Message sent'; else echo 'Error: '.$stmt->error;
  exit;
}
?>