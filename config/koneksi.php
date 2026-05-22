<?php

$conn = mysqli_connect(

    getenv('MYSQLHOST'),
    getenv('MYSQLUSER'),
    getenv('MYSQLPASSWORD'),
    getenv('MYSQLDATABASE'),
    getenv('MYSQLPORT')

);

if (!$conn) {

    die('Koneksi Database Gagal : ' . mysqli_connect_error());

}

?>