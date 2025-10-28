<?php
require_once __DIR__.'/../includes/db.php';
require_once __DIR__.'/../includes/security.php';
session_start();
if(empty($_SESSION['user_id']) || $_SESSION['role']!=='student'){ header('Location:/auth/login.php'); exit; }
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1'); $stmt->execute([$uid]); $u = $stmt->fetch(PDO::FETCH_ASSOC);
$res = $pdo->prepare('SELECT subject,score,grade,term,session,remark FROM results WHERE student_id = ? ORDER BY date_uploaded DESC'); $res->execute([$uid]); $rows = $res->fetchAll(PDO::FETCH_ASSOC);
ob_start();
?>
<html><head><meta charset="utf-8"><style>body{font-family:Arial,Helvetica,sans-serif;}table{width:100%;border-collapse:collapse}td,th{border:1px solid #ddd;padding:6px}</style></head><body>
<h2 style="text-align:center">BODAN INTERNATIONAL SCHOOL</h2>
<p><strong>Name:</strong> <?=htmlspecialchars($u['name'])?> &nbsp; <strong>Class:</strong> <?=htmlspecialchars($u['class'])?> &nbsp; <strong>Date:</strong> <?=date('Y-m-d')?></p>
<table><thead><tr><th>Subject</th><th>Score</th><th>Grade</th><th>Term</th><th>Session</th><th>Remark</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?=htmlspecialchars($r['subject'])?></td><td><?=htmlspecialchars($r['score'])?></td><td><?=htmlspecialchars($r['grade'])?></td><td><?=htmlspecialchars($r['term'])?></td><td><?=htmlspecialchars($r['session'])?></td><td><?=htmlspecialchars($r['remark'])?></td></tr><?php endforeach; ?></tbody></table>
<p style="margin-top:30px">Signature: ______________________</p>
</body></html>
<?php
$html = ob_get_clean();
if(file_exists(__DIR__.'/../vendor/dompdf/autoload.inc.php')){
    require_once __DIR__.'/../vendor/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();
    $dompdf->stream('report_'.$uid.'.pdf', ['Attachment'=>1]);
} else {
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
}
?>
