<?php
$password = "QWERTY123"; // your chosen password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo $hashedPassword;
?>
