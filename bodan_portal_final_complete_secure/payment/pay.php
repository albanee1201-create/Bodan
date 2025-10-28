<?php require_once '../config.php'; if(!is_student()) redirect('../student/login.php');
// Payment logic goes here — original pay.php expected in package. Replace keys in config.php.
echo '<!doctype html><html><head><title>Pay</title></head><body><div class="container"><h1>Payment placeholder</h1><p>Payment flow available in the package; please ensure payment/verify_payment.php is present and Paystack keys set in config.php.</p></div></body></html>';
?>