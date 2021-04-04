<?php
$user_logined = false;

define('DB_DSN', 'mysql:host=localhost;port=3306;dbname=rrc');
define('DB_USER', 'nemo');
define('DB_PASS', 'nemowang');

$today = date("Y-m-d H:i:s");
//$error_file = "error.txt";

try {
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
    //file_put_contents($error_file, $today . ':  ' . $e->getMessage() . "\n", FILE_APPEND);
    var_dump($e);
    exit();
}

session_start();
if (isset($_SESSION['username'])) {
    $user_logined = true;
    //file_put_contents($error_file, $today . ':  ' . 'logined' . "\n", FILE_APPEND);
} else {
    //file_put_contents($error_file, $today . ':  ' . 'logoffed' . "\n", FILE_APPEND);
}
