<?php

$host = $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST');
$user = $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER');
$pass = $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD');
$db   = $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE');
$port = $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT');

$conn = mysqli_connect(
    $host,
    $user,
    $pass,
    $db,
    (int)$port
);

if (!$conn) {

    die('Koneksi database gagal: ' . mysqli_connect_error());

}

?>