<?php
require_once '../config.php';
$res = $conn->query("SELECT id,title,body,created_at FROM announcements ORDER BY created_at DESC LIMIT 10");
$list = [];
while($r=$res->fetch_assoc()) $list[]=$r;
header('Content-Type: application/json');
echo json_encode($list);
?>