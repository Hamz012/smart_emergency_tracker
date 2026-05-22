<?php

session_start();

include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header('Location: login.php');
    exit();
}

/*
========================================
AMBIL DATA LAPORAN
========================================
*/

$query = mysqli_query($conn, "

SELECT laporan.*, users.nama

FROM laporan

LEFT JOIN users
ON laporan.user_id = users.id

ORDER BY laporan.id DESC

");

$total = mysqli_num_rows($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Riwayat Laporan SOS
</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    background:#eef2f7;
    color:#1e293b;
}

/* =========================
LAYOUT
========================= */

.wrapper{
    display:flex;
    min-height:100vh;
}

/* =========================
SIDEBAR
========================= */

.sidebar{
    width:270px;
    background:linear-gradient(180deg,#0f172a,#1e293b);
    color:white;
    padding:30px 20px;
    position:fixed;
    height:100vh;
    box-shadow:0 0 30px rgba(0,0,0,0.1);
}

.logo{
    font-size:26px;
    font-weight:800;
    margin-bottom:40px;
    display:flex;
    align-items:center;
    gap:12px;
}

.logo i{
    background:#2563eb;
    padding:14px;
    border-radius:14px;
}

.menu{
    margin-top:20px;
}

.menu a{
    text-decoration:none;
    color:white;
}

.menu-item{
    padding:16px 18px;
    border-radius:14px;
    margin-bottom:12px;
    display:flex;
    align-items:center;
    gap:15px;
    transition:0.3s;
    cursor:pointer;
    font-weight:600;
    background:rgba(255,255,255,0.04);
}

.menu-item:hover{
    background:#2563eb;
    transform:translateX(5px);
}

.active{
    background:#2563eb;
}

/* =========================
MAIN
========================= */

.main{
    margin-left:270px;
    width:calc(100% - 270px);
    padding:30px;
}

/* =========================
TOPBAR
========================= */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.topbar-title h1{
    font-size:34px;
    font-weight:800;
}

.topbar-title p{
    color:#64748b;
    margin-top:5px;
}

.profile-box{
    background:white;
    padding:14px 20px;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    display:flex;
    align-items:center;
    gap:12px;
    font-weight:600;
}

/* =========================
STATISTICS
========================= */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    position:relative;
    overflow:hidden;
}

.stat-card::before{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    background:rgba(37,99,235,0.08);
    border-radius:50%;
    top:-40px;
    right:-40px;
}

.stat-icon{
    width:55px;
    height:55px;
    border-radius:16px;
    background:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:22px;
    margin-bottom:15px;
}

.stat-card h3{
    color:#64748b;
    font-size:15px;
    margin-bottom:10px;
}

.stat-card h1{
    font-size:36px;
    font-weight:800;
}

/* =========================
CARD
========================= */

.card{
    background:white;
    border-radius:28px;
    padding:25px;
    box-shadow:0 10px 40px rgba(0,0,0,0.05);
}

/* =========================
TABLE
========================= */

.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 14px;
}

table th{
    text-align:left;
    color:#64748b;
    font-size:14px;
    padding:12px;
}

table td{
    background:white;
    padding:18px 15px;
    vertical-align:middle;
}

table tr{
    box-shadow:0 5px 20px rgba(0,0,0,0.04);
}

table tr td:first-child{
    border-radius:18px 0 0 18px;
}

table tr td:last-child{
    border-radius:0 18px 18px 0;
}

/* =========================
BADGE
========================= */

.badge{
    padding:10px 16px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    display:inline-block;
}

/* STATUS COLORS */

.sos{
    background:#fee2e2;
    color:#dc2626;
}

.diterima{
    background:#dbeafe;
    color:#1d4ed8;
}

.menuju{
    background:#fef3c7;
    color:#b45309;
}

.selesai{
    background:#dcfce7;
    color:#15803d;
}

/* =========================
LOCATION BOX
========================= */

.location-box{
    background:#f8fafc;
    padding:10px 14px;
    border-radius:12px;
    font-size:13px;
    font-weight:600;
    color:#334155;
}

/* =========================
EMPTY
========================= */

.empty{
    text-align:center;
    padding:60px 20px;
    color:#94a3b8;
}

.empty i{
    font-size:60px;
    margin-bottom:20px;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:900px){

    .sidebar{
        display:none;
    }

    .main{
        margin-left:0;
        width:100%;
        padding:20px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

}

</style>

</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">
<i class="fa-solid fa-shield-halved"></i>
Smart Police
</div>

<div class="menu">

<a href="dashboard.php">
<div class="menu-item">
<i class="fa-solid fa-gauge"></i>
Dashboard
</div>
</a>

<a href="laporan_sos.php">
<div class="menu-item active">
<i class="fa-solid fa-triangle-exclamation"></i>
Riwayat SOS
</div>
</a>

</div>

</div>

<!-- MAIN -->

<div class="main">

<!-- TOPBAR -->

<div class="topbar">

<div class="topbar-title">
<h1>Riwayat Laporan SOS</h1>
<p>Monitoring seluruh laporan masuk realtime</p>
</div>

<div class="profile-box">
<i class="fa-solid fa-user-shield"></i>
Admin Polisi
</div>

</div>

<!-- STATISTICS -->

<div class="stats">

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-bell"></i>
</div>

<h3>Total Laporan</h3>

<h1>
<?php echo $total; ?>
</h1>

</div>

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-check"></i>
</div>

<h3>Status Sistem</h3>

<h1>
Aktif
</h1>

</div>

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-shield"></i>
</div>

<h3>Monitoring</h3>

<h1>
24/7
</h1>

</div>

</div>

<!-- TABLE -->

<div class="card">

<div class="table-wrapper">

<?php if($total > 0){ ?>

<table>

<tr>

<th>Pelapor</th>
<th>Status</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Kecepatan</th>
<th>Informasi Lokasi</th>

</tr>

<?php while($data = mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<strong>

<?php echo $data['nama']; ?>

</strong>

</td>

<td>

<?php

$statusClass = '';

if($data['status'] == 'SOS Dikirim'){
    $statusClass = 'sos';
}

elseif($data['status'] == 'Laporan Diterima Polisi'){
    $statusClass = 'diterima';
}

elseif($data['status'] == 'Polisi Menuju Lokasi'){
    $statusClass = 'menuju';
}

elseif($data['status'] == 'Laporan Selesai'){
    $statusClass = 'selesai';
}

?>

<span class="badge <?php echo $statusClass; ?>">

<?php echo $data['status']; ?>

</span>

</td>

<td>

<?php echo $data['latitude']; ?>

</td>

<td>

<?php echo $data['longitude']; ?>

</td>

<td>

<?php echo number_format($data['kecepatan'],2); ?>

km/jam

</td>

<td>

<div class="location-box">

<i class="fa-solid fa-location-dot"></i>

Lokasi terdeteksi realtime

</div>

</td>

</tr>

<?php } ?>

</table>

<?php } else { ?>

<div class="empty">

<i class="fa-solid fa-inbox"></i>

<h2>
Belum Ada Laporan SOS
</h2>

<br>

<p>
Sistem belum menerima laporan masuk.
</p>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>
</html>