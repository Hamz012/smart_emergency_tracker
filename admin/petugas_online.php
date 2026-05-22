<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Petugas Online</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    margin:0;
    background:#eef2f7;
    font-family:Inter,sans-serif;
}

.main{
    margin-left:300px;
    padding:40px;
}

.card{
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
}

.online{
    margin-top:20px;
    padding:20px;
    border-radius:20px;
    background:#dcfce7;
    color:#166534;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main">

<div class="card">

<h1>
<i class="fa-solid fa-user-police"></i>
Petugas Online
</h1>

<div class="online">

<i class="fa-solid fa-circle"></i>

Petugas polisi sedang online

</div>

</div>

</div>

</body>
</html>