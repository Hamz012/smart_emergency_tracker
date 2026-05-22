<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header('Location: login_user.php');

    exit();

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Smart Crime Emergency Tracker
</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{

    background:
    linear-gradient(
    135deg,
    #e2e8f0,
    #f8fafc
    );

    min-height:100vh;

    padding:25px;

    color:#0f172a;

    overflow-x:hidden;

}

/* =========================
CONTAINER
========================= */

.container{
    max-width:1400px;
    margin:auto;
}

/* =========================
TOPBAR
========================= */

.topbar{

    background:white;

    border-radius:30px;

    padding:25px 35px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    box-shadow:
    0 10px 40px rgba(0,0,0,0.05);

    margin-bottom:25px;

}

.brand{
    display:flex;
    align-items:center;
    gap:18px;
}

.brand-logo{

    width:70px;
    height:70px;

    border-radius:22px;

    background:
    linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;

    font-size:30px;

    box-shadow:
    0 10px 25px rgba(37,99,235,0.35);

    flex-shrink:0;

}

.brand h1{
    font-size:30px;
    font-weight:800;
    line-height:1.3;
}

.brand p{
    color:#64748b;
    margin-top:5px;
}

.user-box{

    background:#f8fafc;

    padding:14px 20px;

    border-radius:18px;

    display:flex;
    align-items:center;
    gap:12px;

    font-weight:700;

    flex-shrink:0;

}

.user-icon{

    width:45px;
    height:45px;

    border-radius:14px;

    background:#2563eb;

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

}

/* =========================
GRID
========================= */

.grid{

    display:grid;
    grid-template-columns:420px 1fr;
    gap:25px;

}

/* =========================
LEFT PANEL
========================= */

.panel{

    background:white;

    border-radius:30px;

    padding:30px;

    box-shadow:
    0 10px 40px rgba(0,0,0,0.05);

}

/* =========================
STATUS GPS
========================= */

.gps{

    background:#eff6ff;

    border:1px solid #bfdbfe;

    color:#1d4ed8;

    padding:18px;

    border-radius:18px;

    text-align:center;

    font-weight:700;

    margin-bottom:25px;

}

/* =========================
SOS BUTTON
========================= */

.sos-btn{

    width:100%;

    padding:24px;

    border:none;

    border-radius:22px;

    background:
    linear-gradient(
    135deg,
    #ef4444,
    #dc2626
    );

    color:white;

    font-size:24px;
    font-weight:800;

    cursor:pointer;

    transition:0.3s;

    box-shadow:
    0 15px 35px rgba(239,68,68,0.35);

}

.sos-btn:hover{
    transform:translateY(-4px);
}

.processing{
    background:#f59e0b !important;
}

.success{
    background:#22c55e !important;
}

/* =========================
INFO CARD
========================= */

.info-grid{

    margin-top:25px;

    display:grid;
    gap:18px;

}

.info-item{

    background:#f8fafc;

    border-radius:20px;

    padding:20px;

    display:flex;
    justify-content:space-between;
    align-items:center;

}

.info-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.info-icon{

    width:52px;
    height:52px;

    border-radius:16px;

    background:#2563eb;

    color:white;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:20px;

    flex-shrink:0;

}

.info-text h4{
    font-size:14px;
    color:#64748b;
}

.info-text p{
    font-size:17px;
    font-weight:800;
    margin-top:4px;
    word-break:break-word;
}

/* =========================
MAP CARD
========================= */

.map-card{

    background:white;

    border-radius:30px;

    padding:25px;

    box-shadow:
    0 10px 40px rgba(0,0,0,0.05);

}

.map-header{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:20px;

    gap:15px;

}

.map-header h2{
    font-size:26px;
    font-weight:800;
    line-height:1.4;
}

.live-badge{

    background:#dcfce7;

    color:#166534;

    padding:10px 18px;

    border-radius:999px;

    font-weight:700;

    display:flex;
    align-items:center;
    gap:10px;

    flex-shrink:0;

}

.live-dot{

    width:12px;
    height:12px;

    border-radius:50%;

    background:#22c55e;

}

/* =========================
MAP
========================= */

#map{

    width:100%;
    height:700px;

    border-radius:25px;

    overflow:hidden;

}

/* =========================
RESPONSIVE MOBILE
========================= */

@media(max-width:1000px){

    body{
        padding:15px;
    }

    .grid{
        grid-template-columns:1fr;
    }

    .topbar{

        flex-direction:column;

        gap:20px;

        align-items:flex-start;

        padding:22px;

    }

    .brand{
        width:100%;
    }

    .brand-logo{

        width:60px;
        height:60px;

        font-size:24px;

        border-radius:18px;

    }

    .brand h1{
        font-size:22px;
        line-height:1.3;
    }

    .brand p{
        font-size:13px;
    }

    .user-box{

        width:100%;

        justify-content:center;

    }

    .panel,
    .map-card{

        padding:20px;

        border-radius:24px;

    }

    .gps{

        font-size:14px;

        padding:15px;

    }

    .sos-btn{

        padding:22px;

        font-size:20px;

        border-radius:20px;

    }

    .info-item{

        padding:16px;

        border-radius:18px;

    }

    .info-icon{

        width:45px;
        height:45px;

        font-size:18px;

    }

    .info-text h4{
        font-size:13px;
    }

    .info-text p{
        font-size:15px;
    }

    .map-header{

        flex-direction:column;

        align-items:flex-start;

        gap:15px;

    }

    .map-header h2{
        font-size:22px;
        line-height:1.4;
    }

    .live-badge{

        width:100%;

        justify-content:center;

        font-size:13px;

    }

    #map{

        height:450px;

        border-radius:20px;

    }

}

/* =========================
EXTRA SMALL DEVICE
========================= */

@media(max-width:600px){

    body{
        padding:10px;
    }

    .topbar{

        padding:18px;

        border-radius:22px;

    }

    .brand{
        gap:14px;
    }

    .brand-logo{

        width:52px;
        height:52px;

        font-size:20px;

    }

    .brand h1{
        font-size:18px;
    }

    .brand p{
        font-size:12px;
    }

    .user-box{

        padding:12px;

        font-size:14px;

        border-radius:15px;

    }

    .user-icon{

        width:38px;
        height:38px;

    }

    .panel,
    .map-card{

        padding:16px;

        border-radius:20px;

    }

    .gps{

        font-size:13px;

        padding:14px;

        border-radius:15px;

    }

    .sos-btn{

        font-size:18px;

        padding:20px;

        border-radius:18px;

    }

    .info-grid{
        gap:14px;
    }

    .info-item{

        padding:14px;

        border-radius:16px;

    }

    .info-left{
        gap:12px;
    }

    .info-icon{

        width:42px;
        height:42px;

        border-radius:14px;

        font-size:16px;

    }

    .info-text h4{
        font-size:12px;
    }

    .info-text p{
        font-size:14px;
    }

    .map-header h2{
        font-size:18px;
    }

    .live-badge{

        padding:8px 14px;

        font-size:12px;

    }

    #map{

        height:350px;

        border-radius:18px;

    }

}

</style>

</head>

<body>

<div class="container">

<!-- TOPBAR -->

<div class="topbar">

<div class="brand">

<div class="brand-logo">

<i class="fa-solid fa-shield-halved"></i>

</div>

<div>

<h1>
Smart Crime Emergency Tracker
</h1>

<p>
Pelaporan darurat realtime berbasis GPS
</p>

</div>

</div>

<div class="user-box">

<div class="user-icon">

<i class="fa-solid fa-user"></i>

</div>

Pelapor Aktif

</div>

</div>

<!-- GRID -->

<div class="grid">

<!-- LEFT PANEL -->

<div class="panel">

<div
class="gps"
id="gpsStatus">

<i class="fa-solid fa-location-dot"></i>

Memeriksa GPS...

</div>

<button
id="sosBtn"
class="sos-btn"
onclick="aktifkanSOS()">

<i class="fa-solid fa-triangle-exclamation"></i>

SOS DARURAT

</button>

<div class="info-grid">

<div class="info-item">

<div class="info-left">

<div class="info-icon">

<i class="fa-solid fa-circle-info"></i>

</div>

<div class="info-text">

<h4>Status</h4>

<p id="status">
Belum Ada Laporan
</p>

</div>

</div>

</div>

<div class="info-item">

<div class="info-left">

<div class="info-icon">

<i class="fa-solid fa-car"></i>

</div>

<div class="info-text">

<h4>Kecepatan Polisi</h4>

<p>
<span id="policeSpeed">-</span>
km/jam
</p>

</div>

</div>

</div>

<div class="info-item">

<div class="info-left">

<div class="info-icon">

<i class="fa-solid fa-route"></i>

</div>

<div class="info-text">

<h4>Jarak Polisi</h4>

<p>
<span id="jarakPolisi">-</span>
km
</p>

</div>

</div>

</div>

<div class="info-item">

<div class="info-left">

<div class="info-icon">

<i class="fa-solid fa-clock"></i>

</div>

<div class="info-text">

<h4>Estimasi Polisi</h4>

<p>
<span id="estimasiPolisi">-</span>
menit
</p>

</div>

</div>

</div>

</div>

</div>

<!-- MAP -->

<div class="map-card">

<div class="map-header">

<h2>

<i class="fa-solid fa-map-location-dot"></i>

Live Tracking Map

</h2>

<div class="live-badge">

<div class="live-dot"></div>

Realtime GPS

</div>

</div>

<div id="map"></div>

</div>

</div>

</div>

<script>

let laporanId = null;

let reconnectToken = null;

let gpsAktif = false;

let watchId = null;

const map = L.map('map').setView(
[-8.650000,115.216667],
13
);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

let markerPelapor = null;

let markerPolisi = null;

let routeLine = null;

/*
========================================
GPS
========================================
*/

window.onload = function(){

    navigator.geolocation.getCurrentPosition(

        function(position){

            gpsAktif = true;

            document
            .getElementById(
                'gpsStatus'
            )
            .innerHTML =

            '<i class="fa-solid fa-circle-check"></i> GPS Aktif & Terhubung';

        },

        function(){

            gpsAktif = false;

            alert(
            'WAJIB mengaktifkan GPS'
            );

        }

    );

}

/*
========================================
SOS
========================================
*/

function aktifkanSOS(){

    if(!gpsAktif){

        alert(
        'GPS belum aktif'
        );

        return;

    }

    const btn =
    document.getElementById(
        'sosBtn'
    );

    btn.disabled = true;

    btn.innerHTML =

    '<i class="fa-solid fa-spinner fa-spin"></i> SOS Sedang Dikirim';

    btn.classList.add(
        'processing'
    );

    watchId =
    navigator.geolocation.watchPosition(

    function(position){

        let latitude =
        position.coords.latitude;

        let longitude =
        position.coords.longitude;

        let speed =
        position.coords.speed || 0;

        speed = speed * 3.6;

        if(!markerPelapor){

            markerPelapor =
            L.marker([
                latitude,
                longitude
            ])

            .addTo(map)

            .bindPopup(
            'Lokasi Pelapor'
            );

        }else{

            markerPelapor.setLatLng([
                latitude,
                longitude
            ]);

        }

        map.setView([
            latitude,
            longitude
        ],15);

        fetch(
        'simpan_laporan.php',
        {

            method:'POST',

            headers:{
                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:

            'latitude=' + latitude +

            '&longitude=' + longitude +

            '&speed=' + speed +

            '&laporan_id=' + (laporanId || '') +

            '&reconnect_token=' + (reconnectToken || '')

        })

        .then(response => response.json())

        .then(data => {

            if(data.success){

                laporanId =
                data.id;

                reconnectToken =
                data.reconnect_token;

                document
                .getElementById(
                    'status'
                )
                .innerHTML =

                'SOS berhasil dikirim';

            }

        });

    },

    function(error){

        console.log(error);

    },

    {

        enableHighAccuracy:true,
        maximumAge:0,
        timeout:5000

    });

    cekStatus();

}

/*
========================================
STATUS
========================================
*/

function cekStatus(){

    setInterval(() => {

        if(!laporanId){
            return;
        }

        fetch(
        'cek_status.php?id='+
        laporanId
        )

        .then(response => response.json())

        .then(data => {

            if(!data){
                return;
            }

            document
            .getElementById(
                'status'
            )
            .innerHTML =
            data.status;

            if(
            data.police_latitude &&
            data.police_longitude
            ){

                let policeLat =
                parseFloat(
                data.police_latitude
                );

                let policeLng =
                parseFloat(
                data.police_longitude
                );

                if(!markerPolisi){

                    markerPolisi =
                    L.marker([
                        policeLat,
                        policeLng
                    ])

                    .addTo(map)

                    .bindPopup(
                    'Posisi Polisi'
                    );

                }else{

                    markerPolisi.setLatLng([
                        policeLat,
                        policeLng
                    ]);

                }

            }

            document
            .getElementById(
                'policeSpeed'
            )
            .innerHTML =

            parseFloat(
            data.police_speed || 0
            ).toFixed(2);

            document
            .getElementById(
                'jarakPolisi'
            )
            .innerHTML =

            parseFloat(
            data.jarak_polisi || 0
            ).toFixed(2);

            document
            .getElementById(
                'estimasiPolisi'
            )
            .innerHTML =

            parseFloat(
            data.estimasi_waktu || 0
            ).toFixed(0);

            if(
            data.status ==
            'Laporan Diterima Polisi'
            ){

                const btn =
                document.getElementById(
                    'sosBtn'
                );

                btn.innerHTML =

                '<i class="fa-solid fa-circle-check"></i> Laporan Diterima Polisi';

                btn.classList.remove(
                    'processing'
                );

                btn.classList.add(
                    'success'
                );

            }

            if(
            data.status ==
            'Polisi Menuju Lokasi'
            ){

                if(
                markerPelapor &&
                markerPolisi
                ){

                    let pelaporLatLng =
                    markerPelapor.getLatLng();

                    let polisiLatLng =
                    markerPolisi.getLatLng();

                    if(routeLine){

                        map.removeLayer(
                            routeLine
                        );

                    }

                    routeLine =
                    L.polyline([

                        polisiLatLng,
                        pelaporLatLng

                    ],{

                        color:'#2563eb',
                        weight:5

                    })

                    .addTo(map);

                    map.fitBounds([

                        polisiLatLng,
                        pelaporLatLng

                    ]);

                }

            }

            if(
            data.status ==
            'Laporan Selesai'
            ){

                const btn =
                document.getElementById(
                    'sosBtn'
                );

                btn.innerHTML =

                '<i class="fa-solid fa-circle-check"></i> Laporan Selesai';

                btn.classList.remove(
                    'processing'
                );

                btn.classList.add(
                    'success'
                );

                if(routeLine){

                    map.removeLayer(
                        routeLine
                    );

                }

            }

        });

    },3000);

}


</script>

</body>
</html>