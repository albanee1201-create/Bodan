<?php
require_once 'config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = esc($_POST['name']);
    $email = esc($_POST['email']);
    $class = esc($_POST['class']);
    $session = esc($_POST['session']);
    $phone = esc($_POST['phone']);
    $notes = esc($_POST['notes']);

    $stmt = $conn->prepare("INSERT INTO students (name, email, class, session_year, password) VALUES (?, ?, ?, ?, '')");
    $stmt->bind_param('ssss', $name, $email, $class, $session);
    if ($stmt->execute()){
        $message = 'Registration submitted successfully. Admin will review and approve.';
    } else {
        $message = 'Error: ' . $stmt->error;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admission - Bodan</title>
<link rel="stylesheet" href="assets/css/styles.css"></head>
<body>
  <div class="container">
    <h1>Admission Form</h1>
    <?php if($message) echo '<p class="notice">'. $message .'</p>'; ?>
    <form method="post">
      <label>Name</label>
      <input type="text" name="name" required>
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Class applying for</label>
      <input type="text" name="class" required>
      <label>Session (e.g., 2024/2025)</label>
      <input type="text" name="session" required>
      <label>Phone</label>
      <input type="text" name="phone">
      <label>Additional Notes</label>
      <textarea name="notes"></textarea>
      <button type="submit" class="btn">Submit</button>
    </form>
  </div>
</body>
</html>
