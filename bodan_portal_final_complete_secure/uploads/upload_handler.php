<?php
require_once '../config.php';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['file'])){
  $uploaded_by = esc($_POST['uploaded_by']);
  $desc = esc($_POST['description']);
  $f = $_FILES['file'];
  $target_dir = __DIR__ . '/../uploads/';
  if(!is_dir($target_dir)) mkdir($target_dir, 0755, true);
  $filename = time() . '_' . basename($f['name']);
  $path = $target_dir . $filename;
  if(move_uploaded_file($f['tmp_name'], $path)){
    $stmt = $conn->prepare("INSERT INTO uploads (uploaded_by, filename, filepath, filetype, description) VALUES (?,?,?,?,?)");
    $filetype = esc($f['type']);
    $relpath = 'uploads/' . $filename;
    $stmt->bind_param('sssss',$uploaded_by,$filename,$relpath,$filetype,$desc);
    $stmt->execute();
    echo 'Uploaded';
  } else echo 'Upload failed';
  exit;
}
?>