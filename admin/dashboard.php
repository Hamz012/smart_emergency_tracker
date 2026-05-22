<?php

session_start();

include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header('Location: login.php');
    exit();
}

/*
========================================
ACC LAPORAN
========================================
*/

if(isset($_GET['acc'])){

    $id = $_GET['acc'];

    mysqli_query($conn,"
    UPDATE laporan
    SET status='Laporan Diterima Polisi'
    WHERE id='$id'
    ");

    echo "success";
    exit();
}

/*
========================================
MENUJU LOKASI
========================================
*/

if(isset($_GET['menuju'])){

    $id = $_GET['menuju'];

    mysqli_query($conn,"
    UPDATE laporan
    SET status='Polisi Menuju Lokasi'
    WHERE id='$id'
    ");

    echo "success";
    exit();
}

/*
========================================
SELESAI
========================================
*/

if(isset($_GET['selesai'])){

    $id = $_GET['selesai'];

    mysqli_query($conn,"
    UPDATE laporan
    SET status='Laporan Selesai'
    WHERE id='$id'
    ");

    echo "success";
    exit();
}

/*
========================================
HAPUS
========================================
*/

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    mysqli_query($conn,"
    DELETE FROM laporan
    WHERE id='$id'
    ");

    echo "success";
    exit();
}

/*
========================================
AMBIL DATA
========================================
*/

$query = mysqli_query($conn,"
SELECT laporan.*, users.nama
FROM laporan
LEFT JOIN users
ON laporan.user_id = users.id
ORDER BY laporan.id DESC
");

$totalLaporan = mysqli_num_rows($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Dashboard Polisi</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<link rel="stylesheet"
href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css"/>

<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

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

.wrapper{
    display:flex;
    min-height:100vh;
}

/*
========================================
SIDEBAR
========================================
*/

.sidebar{
    width:280px;
    background:linear-gradient(180deg,#0f172a,#111827);
    color:white;
    padding:25px 18px;
    position:fixed;
    height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:0 0 30px rgba(0,0,0,0.15);
}

.logo{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:40px;
}

.logo i{
    width:58px;
    height:58px;
    border-radius:18px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.logo h2{
    font-size:22px;
    font-weight:800;
}

.logo span{
    font-size:13px;
    color:#94a3b8;
}

.menu{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.menu-link{
    text-decoration:none;
    color:white;
}

.menu-item{
    display:flex;
    align-items:center;
    gap:14px;
    padding:16px;
    border-radius:18px;
    transition:0.3s;
    cursor:pointer;
    background:rgba(255,255,255,0.03);
}

.menu-item:hover{
    background:rgba(37,99,235,0.15);
    transform:translateX(5px);
}

.active{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
}

.menu-icon{
    width:48px;
    height:48px;
    border-radius:14px;
    background:rgba(255,255,255,0.08);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}

.menu-content h4{
    font-size:15px;
    font-weight:700;
}

.menu-content p{
    font-size:12px;
    color:#cbd5e1;
}

.sidebar-footer{
    margin-top:30px;
}

.footer-box{
    background:rgba(255,255,255,0.05);
    padding:16px;
    border-radius:18px;
    display:flex;
    align-items:center;
    gap:12px;
}

.online-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    background:#22c55e;
}

/*
========================================
MAIN
========================================
*/

.main{
    margin-left:280px;
    width:calc(100% - 280px);
    padding:30px;
}

/*
========================================
TOPBAR
========================================
*/

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

/*
========================================
STATS
========================================
*/

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
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

/*
========================================
CARD
========================================
*/

.card{
    background:white;
    border-radius:28px;
    padding:25px;
    margin-bottom:30px;
    box-shadow:0 10px 40px rgba(0,0,0,0.05);
}

.card-title{
    margin-bottom:20px;
}

.card-title h2{
    font-size:24px;
    font-weight:800;
}

/*
========================================
MAP
========================================
*/

#map{
    width:100%;
    height:550px;
    border-radius:24px;
}

/*
========================================
STATUS
========================================
*/

.status-box{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
    background:#f8fafc;
    padding:14px 18px;
    border-radius:16px;
    width:max-content;
}

.dot{
    width:14px;
    height:14px;
    border-radius:50%;
}

.online{
    background:#22c55e;
}

.offline{
    background:#ef4444;
}

/*
========================================
TABLE
========================================
*/

.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
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

/*
========================================
BADGE
========================================
*/

.badge{
    padding:10px 16px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    display:inline-block;
    background:#fee2e2;
    color:#dc2626;
}

/*
========================================
BUTTON
========================================
*/

.btn{
    border:none;
    padding:12px 18px;
    border-radius:14px;
    color:white;
    cursor:pointer;
    font-weight:700;
    transition:0.3s;
    margin:3px;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-acc{
    background:#22c55e;
}

.btn-menuju{
    background:#2563eb;
}

.btn-selesai{
    background:#f59e0b;
}

.btn-hapus{
    background:#ef4444;
}

/*
========================================
ROUTE INFO
========================================
*/

.info-route{
    margin-top:20px;
    background:#eff6ff;
    border-left:5px solid #2563eb;
    padding:18px;
    border-radius:18px;
    color:#1e40af;
    font-weight:700;
}

/*
========================================
CUSTOM MAP ICON
========================================
*/

.police-icon{

    background:#2563eb;
    width:55px;
    height:55px;
    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;
    font-size:26px;

    border:4px solid white;

    box-shadow:0 5px 20px rgba(37,99,235,0.4);

}

.user-icon-map{

    background:#22c55e;
    width:55px;
    height:55px;
    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;
    font-size:26px;

    border:4px solid white;

    box-shadow:0 5px 20px rgba(34,197,94,0.4);

}

/*
========================================
RESPONSIVE
========================================
*/

@media(max-width:900px){

    .sidebar{
        display:none;
    }

    .main{
        margin-left:0;
        width:100%;
    }

}

</style>

</head>

<body>

<div class="wrapper">

<div class="sidebar">

<div>

<div class="logo">

<i class="fa-solid fa-shield-halved"></i>

<div>
<h2>Smart Police</h2>
<span>Emergency System</span>
</div>

</div>

<div class="menu">

<a href="dashboard.php" class="menu-link">

<div class="menu-item active">

<div class="menu-icon">
<i class="fa-solid fa-gauge"></i>
</div>

<div class="menu-content">
<h4>Dashboard</h4>
<p>Monitoring realtime</p>
</div>

</div>

</a>

</div>

</div>

<div class="sidebar-footer">

<div class="footer-box">

<div class="online-dot"></div>

<span>Sistem Polisi Aktif</span>

</div>

</div>

</div>

<div class="main">

<div class="topbar">

<div class="topbar-title">

<h1>Dashboard Polisi</h1>

<p>Monitoring laporan SOS realtime</p>

</div>

<div class="profile-box">

<i class="fa-solid fa-user-shield"></i>

Online

</div>

</div>

<div class="stats">

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-bell"></i>
</div>

<h3>Total Laporan</h3>

<h1>
<?php echo $totalLaporan; ?>
</h1>

</div>

</div>

<div class="card">

<div class="card-title">

<h2>
<i class="fa-solid fa-map-location-dot"></i>
Tracking Polisi & SOS
</h2>

</div>

<div class="status-box">

<div class="dot online" id="statusDot"></div>

<span id="statusText">
Memeriksa GPS...
</span>

</div>

<div id="map"></div>

<div class="info-route" id="routeInfo">
Menunggu laporan SOS...
</div>

</div>

<div class="card">

<div class="card-title">

<h2>
<i class="fa-solid fa-list"></i>
Daftar Laporan
</h2>

</div>

<div class="table-wrapper">

<table>

<tr>

<th>Pelapor</th>
<th>Status</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Kecepatan</th>
<th>Aksi</th>

</tr>

<?php while($data = mysqli_fetch_assoc($query)){ ?>

<tr>

<td><?php echo $data['nama']; ?></td>

<td>

<span class="badge">
<?php echo $data['status']; ?>
</span>

</td>

<td><?php echo $data['latitude']; ?></td>

<td><?php echo $data['longitude']; ?></td>

<td>

<?php echo number_format($data['kecepatan'],2); ?>

km/jam

</td>

<td>

<?php if($data['status'] == 'SOS Dikirim'){ ?>

<button
onclick="accLaporan(<?php echo $data['id']; ?>)"
class="btn btn-acc">

<i class="fa-solid fa-check"></i>
ACC

</button>

<?php } ?>

<?php if($data['status'] == 'Laporan Diterima Polisi'){ ?>

<button
onclick="menujuLokasi(
<?php echo $data['id']; ?>,
<?php echo $data['latitude']; ?>,
<?php echo $data['longitude']; ?>
)"
class="btn btn-menuju">

<i class="fa-solid fa-route"></i>
Menuju

</button>

<?php } ?>

<?php if($data['status'] == 'Polisi Menuju Lokasi'){ ?>

<button
onclick="selesaiLaporan(
<?php echo $data['id']; ?>
)"
class="btn btn-selesai">

<i class="fa-solid fa-circle-check"></i>
Selesai

</button>

<?php } ?>

<?php if($data['status'] == 'Laporan Selesai'){ ?>

<button
onclick="hapusLaporan(
<?php echo $data['id']; ?>
)"
class="btn btn-hapus">

<i class="fa-solid fa-trash"></i>
Hapus

</button>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

<script>

const map = L.map('map').setView(
[-8.650000,115.216667],
13
);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

/*
========================================
CUSTOM ICON
========================================
*/

const policeIcon = L.divIcon({

    html: `
    <div class="police-icon">
        <i class="fa-solid fa-car-side"></i>
    </div>
    `,

    className:'',
    iconSize:[55,55],
    iconAnchor:[27,27]

});

const userIcon = L.divIcon({

    html: `
    <div class="user-icon-map">
        <i class="fa-solid fa-mobile-screen-button"></i>
    </div>
    `,

    className:'',
    iconSize:[55,55],
    iconAnchor:[27,27]

});

let policeMarker = null;
let pelaporMarker = null;
let routingControl = null;

let currentSOSLat = null;
let currentSOSLng = null;

/*
========================================
GPS POLISI
========================================
*/

navigator.geolocation.watchPosition(

function(position){

    document
    .getElementById('statusDot')
    .classList.remove('offline');

    document
    .getElementById('statusDot')
    .classList.add('online');

    document
    .getElementById('statusText')
    .innerHTML =
    'Polisi Online';

    const policeLat =
    position.coords.latitude;

    const policeLng =
    position.coords.longitude;

    if(!policeMarker){

        policeMarker =
        L.marker(
        [
            policeLat,
            policeLng
        ],
        {
            icon: policeIcon
        }
        )
        .addTo(map)
        .bindPopup('Mobil Polisi');

    }else{

        policeMarker.setLatLng([
            policeLat,
            policeLng
        ]);

    }

},

function(){

    document
    .getElementById('statusDot')
    .classList.remove('online');

    document
    .getElementById('statusDot')
    .classList.add('offline');

    document
    .getElementById('statusText')
    .innerHTML =
    'GPS Polisi Offline';

},

{
    enableHighAccuracy:true,
    maximumAge:0,
    timeout:5000
}

);

function accLaporan(id){

    fetch('dashboard.php?acc='+id)

    .then(() => {

        location.reload();

    });

}

function hapusLaporan(id){

    if(confirm('Hapus laporan ini?')){

        fetch('dashboard.php?hapus='+id)

        .then(() => {

            location.reload();

        });

    }

}

function selesaiLaporan(id){

    fetch('dashboard.php?selesai='+id)

    .then(() => {

        if(routingControl){

            map.removeControl(
                routingControl
            );

        }

        document
        .getElementById('routeInfo')
        .innerHTML =
        'Laporan selesai ditangani polisi';

        setTimeout(() => {

            location.reload();

        },1000);

    });

}

function menujuLokasi(id,lat,lng){

    currentSOSLat =
    parseFloat(lat);

    currentSOSLng =
    parseFloat(lng);

    fetch(
    'dashboard.php?menuju='+id
    );

    document
    .getElementById('routeInfo')
    .innerHTML =
    'Mencari rute tercepat menuju pelapor...';

    navigator.geolocation.watchPosition(

    function(position){

        const policeLat =
        position.coords.latitude;

        const policeLng =
        position.coords.longitude;

        let policeSpeed =
        position.coords.speed || 0;

        policeSpeed =
        policeSpeed * 3.6;

        if(!policeMarker){

            policeMarker =
            L.marker(
            [
                policeLat,
                policeLng
            ],
            {
                icon: policeIcon
            }
            )
            .addTo(map)
            .bindPopup('Mobil Polisi');

        }else{

            policeMarker.setLatLng([
                policeLat,
                policeLng
            ]);

        }

        if(!pelaporMarker){

            pelaporMarker =
            L.marker(
            [
                currentSOSLat,
                currentSOSLng
            ],
            {
                icon:userIcon
            }
            )
            .addTo(map)
            .bindPopup('Handphone Pelapor');

        }else{

            pelaporMarker.setLatLng([
                currentSOSLat,
                currentSOSLng
            ]);

        }

        map.fitBounds([

            [policeLat, policeLng],

            [currentSOSLat, currentSOSLng]

        ]);

        if(routingControl){

            map.removeControl(
                routingControl
            );

        }

        routingControl =
        L.Routing.control({

            waypoints:[

                L.latLng(
                    policeLat,
                    policeLng
                ),

                L.latLng(
                    currentSOSLat,
                    currentSOSLng
                )

            ],

            addWaypoints:false,

            draggableWaypoints:false,

            fitSelectedRoutes:true,

            routeWhileDragging:true,

            show:false,

            createMarker:function(){
                return null;
            },

            lineOptions:{

                styles:[{

                    color:'#2563eb',
                    opacity:0.9,
                    weight:7

                }]

            }

        }).addTo(map);

        let jarak =
        map.distance(

            [policeLat, policeLng],

            [currentSOSLat, currentSOSLng]

        ) / 1000;

        let estimasi = 0;

        if(policeSpeed > 0){

            estimasi =
            (jarak / policeSpeed) * 60;

        }

        fetch(
        '../update_polisi.php',
        {

            method:'POST',

            headers:{
                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:

            'id=' + id +

            '&latitude=' + policeLat +

            '&longitude=' + policeLng +

            '&speed=' + policeSpeed +

            '&jarak=' + jarak +

            '&estimasi=' + estimasi

        });

        document
        .getElementById('routeInfo')
        .innerHTML =

        'Navigasi aktif | '

        +

        'Kecepatan Polisi: '

        +

        policeSpeed.toFixed(2)

        +

        ' km/jam | '

        +

        'Jarak: '

        +

        jarak.toFixed(2)

        +

        ' km | '

        +

        'Estimasi: '

        +

        estimasi.toFixed(0)

        +

        ' menit';

    },

    function(error){

        console.log(error);

    },

    {

        enableHighAccuracy:true,
        maximumAge:0,
        timeout:5000

    });

}

</script>

</body>
</html>