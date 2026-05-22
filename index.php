<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Smart Emergency Tracker
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

    min-height:100vh;

    background:
    linear-gradient(
    135deg,
    #0f172a,
    #1e293b,
    #2563eb
    );

    display:flex;
    justify-content:center;
    align-items:center;

    overflow:hidden;

    position:relative;

}

/* =========================
BACKGROUND EFFECT
========================= */

.bg-circle{

    position:absolute;

    border-radius:50%;

    background:
    rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    animation:float 6s ease-in-out infinite;

}

.bg1{

    width:300px;
    height:300px;

    top:-100px;
    left:-100px;

}

.bg2{

    width:250px;
    height:250px;

    bottom:-80px;
    right:-80px;

    animation-delay:2s;

}

@keyframes float{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-20px);
    }

    100%{
        transform:translateY(0px);
    }

}

/* =========================
CARD
========================= */

.splash-card{

    width:100%;
    max-width:500px;

    background:
    rgba(255,255,255,0.12);

    border:
    1px solid rgba(255,255,255,0.15);

    backdrop-filter:blur(15px);

    border-radius:35px;

    padding:45px 35px;

    text-align:center;

    box-shadow:
    0 20px 50px rgba(0,0,0,0.25);

    position:relative;

    z-index:10;

}

/* =========================
LOGO
========================= */

.logo{

    width:120px;
    height:120px;

    margin:auto;

    border-radius:35px;

    background:
    linear-gradient(
    135deg,
    #2563eb,
    #0ea5e9
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;

    font-size:55px;

    box-shadow:
    0 15px 35px rgba(37,99,235,0.45);

    margin-bottom:30px;

    animation:pulse 2s infinite;

}

@keyframes pulse{

    0%{
        transform:scale(1);
    }

    50%{
        transform:scale(1.05);
    }

    100%{
        transform:scale(1);
    }

}

/* =========================
TEXT
========================= */

h1{

    color:white;

    font-size:38px;

    font-weight:800;

    margin-bottom:15px;

}

.desc{

    color:#dbeafe;

    font-size:16px;

    line-height:1.7;

    margin-bottom:40px;

}

/* =========================
BUTTONS
========================= */

.button-group{

    display:flex;
    flex-direction:column;

    gap:20px;

}

.btn{

    width:100%;

    padding:20px;

    border:none;

    border-radius:22px;

    color:white;

    font-size:18px;

    font-weight:700;

    cursor:pointer;

    transition:0.3s;

    text-decoration:none;

    display:flex;
    justify-content:center;
    align-items:center;
    gap:14px;

}

.btn:hover{

    transform:
    translateY(-5px);

}

.btn-police{

    background:
    linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
    );

    box-shadow:
    0 12px 30px rgba(37,99,235,0.35);

}

.btn-user{

    background:
    linear-gradient(
    135deg,
    #22c55e,
    #16a34a
    );

    box-shadow:
    0 12px 30px rgba(34,197,94,0.35);

}

/* =========================
FOOTER
========================= */

.footer{

    margin-top:35px;

    color:#cbd5e1;

    font-size:14px;

}

/* =========================
RESPONSIVE
========================= */

@media(max-width:600px){

    body{
        padding:20px;
    }

    .splash-card{

        padding:35px 25px;

        border-radius:28px;

    }

    .logo{

        width:95px;
        height:95px;

        font-size:42px;

        border-radius:28px;

    }

    h1{

        font-size:28px;

    }

    .desc{

        font-size:14px;

    }

    .btn{

        padding:18px;

        font-size:16px;

        border-radius:18px;

    }

}

</style>

</head>

<body>

<!-- BACKGROUND -->

<div class="bg-circle bg1"></div>

<div class="bg-circle bg2"></div>

<!-- CARD -->

<div class="splash-card">

<div class="logo">

<i class="fa-solid fa-shield-halved"></i>

</div>

<h1>
Smart Emergency Tracker
</h1>

<p class="desc">

Sistem pelaporan darurat realtime berbasis GPS
untuk menghubungkan masyarakat dan kepolisian
secara cepat, aman, dan modern.

</p>

<div class="button-group">

<!-- LOGIN POLISI -->

<a
href="admin/login.php"
class="btn btn-police">

<i class="fa-solid fa-user-shield"></i>

Masuk Sebagai Polisi

</a>

<!-- LOGIN PELAPOR -->

<a
href="login_user.php"
class="btn btn-user">

<i class="fa-solid fa-user"></i>

Masuk Sebagai Pelapor

</a>

</div>

<div class="footer">

© 2026 Smart Emergency Tracker

</div>

</div>

</body>
</html>