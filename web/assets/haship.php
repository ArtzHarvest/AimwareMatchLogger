<?php
if (!isset($_GET['ip'])) {
    die("Error: Missing data");
}
$ip = $_GET['ip'];

$salt = generateSalt();
$hashed_ip = hash('sha256', $ip . $salt);
echo $hashed_ip;

function generateSalt() {
    $length = 10;
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $salt = '';
    for ($i = 0; $i < $length; $i++) {
        $salt .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $salt;
}
?>
