<?php

session_start();

include 'config/koneksi.php';

$error = '';

if(isset($_POST['login'])){

    $nama =
    mysqli_real_escape_string(
    $conn,
    $_POST['nama']
    );

    $query = mysqli_query($conn,

    "

    SELECT * FROM users

    WHERE nama='$nama'

    "

    );

    $data =
    mysqli_fetch_assoc($query);

    if($data){

        $_SESSION['user_id'] =
        $data['id'];

        $_SESSION['nama'] =
        $data['nama'];

        header(
        'Location: dashboard.php'
        );

        exit();

    }else{

        $error =
        'Nama tidak ditemukan';

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Login Pelapor
</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(
    135deg,
    #0f172a 0%,
    #0f766e 50%,
    #22c55e 100%
    );

    overflow:hidden;

    position:relative;

    padding:20px;

}

/* =========================
BACKGROUND EFFECT
========================= */

.bg-circle{

    position:absolute;

    border-radius:50%;

    background:
    rgba(255,255,255,0.08);

    filter:blur(5px);

    animation:float 8s ease-in-out infinite;

}

.bg1{

    width:350px;
    height:350px;

    top:-120px;
    left:-120px;

}

.bg2{

    width:280px;
    height:280px;

    bottom:-100px;
    right:-100px;

    animation-delay:2s;

}

.bg3{

    width:180px;
    height:180px;

    top:50%;
    left:10%;

    animation-delay:4s;

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
LOGIN BOX
========================= */

.login-box{

    width:100%;
    max-width:430px;

    background:
    rgba(255,255,255,0.12);

    backdrop-filter:blur(18px);

    border:
    1px solid rgba(255,255,255,0.15);

    border-radius:32px;

    padding:45px 35px;

    box-shadow:
    0 25px 70px rgba(0,0,0,0.35);

    position:relative;

    z-index:10;

}

/* =========================
TOP BADGE
========================= */

.top-badge{

    display:flex;
    justify-content:center;

    margin-bottom:20px;

}

.badge{

    background:
    rgba(255,255,255,0.15);

    color:#ecfdf5;

    padding:8px 18px;

    border-radius:999px;

    font-size:13px;

    border:
    1px solid rgba(255,255,255,0.15);

}

/* =========================
LOGO
========================= */

.logo{

    width:105px;
    height:105px;

    margin:auto;

    border-radius:28px;

    background:
    linear-gradient(
    135deg,
    #22c55e,
    #15803d
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;

    font-size:42px;

    box-shadow:
    0 15px 35px rgba(34,197,94,0.45);

    margin-bottom:28px;

    position:relative;

}

.logo::after{

    content:'';

    position:absolute;

    inset:-8px;

    border-radius:35px;

    border:
    2px solid rgba(255,255,255,0.15);

}

/* =========================
TEXT
========================= */

h1{

    color:white;

    text-align:center;

    font-size:34px;

    font-weight:700;

    margin-bottom:12px;

    letter-spacing:0.5px;

}

.desc{

    text-align:center;

    color:#d1fae5;

    margin-bottom:35px;

    font-size:14px;

    line-height:1.8;

}

/* =========================
ERROR
========================= */

.error{

    background:
    rgba(239,68,68,0.15);

    border:
    1px solid rgba(239,68,68,0.3);

    color:#fee2e2;

    padding:15px;

    border-radius:18px;

    margin-bottom:22px;

    text-align:center;

    font-size:14px;

    font-weight:500;

}

/* =========================
INPUT GROUP
========================= */

.input-group{

    margin-bottom:24px;

}

.label{

    color:white;

    font-size:14px;

    font-weight:600;

    margin-bottom:10px;

    display:block;

}

.input-box{

    position:relative;

}

.input-box i{

    position:absolute;

    top:50%;

    left:18px;

    transform:translateY(-50%);

    color:#bbf7d0;

    font-size:17px;

}

input{

    width:100%;

    padding:18px 18px 18px 55px;

    border:none;

    border-radius:18px;

    background:
    rgba(255,255,255,0.14);

    color:white;

    font-size:15px;

    outline:none;

    transition:0.3s;

    border:
    1px solid transparent;

}

input::placeholder{

    color:#d1fae5;

}

input:focus{

    background:
    rgba(255,255,255,0.18);

    border:
    1px solid rgba(255,255,255,0.25);

    box-shadow:
    0 0 0 4px rgba(255,255,255,0.08);

}

/* =========================
BUTTON
========================= */

button{

    width:100%;

    padding:18px;

    border:none;

    border-radius:20px;

    background:
    linear-gradient(
    135deg,
    #22c55e,
    #16a34a
    );

    color:white;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s;

    box-shadow:
    0 15px 35px rgba(34,197,94,0.35);

}

button:hover{

    transform:
    translateY(-3px);

    box-shadow:
    0 20px 40px rgba(34,197,94,0.45);

}

/* =========================
REGISTER
========================= */

.register{

    margin-top:25px;

    text-align:center;

    color:#d1fae5;

    font-size:14px;

}

.register a{

    color:white;

    text-decoration:none;

    font-weight:600;

    transition:0.3s;

}

.register a:hover{

    opacity:0.8;

}

/* =========================
FOOTER
========================= */

.footer{

    text-align:center;

    margin-top:30px;

    color:#d1fae5;

    font-size:13px;

    opacity:0.9;

}

/* =========================
RESPONSIVE
========================= */

@media(max-width:600px){

    .login-box{

        padding:35px 25px;

        border-radius:28px;

    }

    .logo{

        width:90px;
        height:90px;

        font-size:35px;

    }

    h1{

        font-size:28px;

    }

    .desc{

        font-size:13px;

    }

    input{

        padding:16px 16px 16px 50px;

    }

    button{

        padding:16px;

    }

}

</style>

</head>

<body>

<!-- BACKGROUND -->

<div class="bg-circle bg1"></div>

<div class="bg-circle bg2"></div>

<div class="bg-circle bg3"></div>

<!-- LOGIN -->

<div class="login-box">

<div class="top-badge">

<div class="badge">

Smart Emergency Tracker

</div>

</div>

<div class="logo">

<i class="fa-solid fa-shield-heart"></i>

</div>

<h1>
Login Pelapor
</h1>

<p class="desc">

Masuk untuk mengakses dashboard pelaporan,
monitoring darurat, dan sistem keamanan realtime.

</p>

<?php if($error != ''){ ?>

<div class="error">

<i class="fa-solid fa-circle-exclamation"></i>

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="input-group">

<label class="label">
Nama Pelapor
</label>

<div class="input-box">

<i class="fa-solid fa-user"></i>

<input
type="text"
name="nama"
placeholder="Masukkan nama lengkap"
required>

</div>

</div>

<button
type="submit"
name="login">

<i class="fa-solid fa-right-to-bracket"></i>

Masuk Dashboard

</button>

</form>

<div class="register">

Belum punya akun?
<a href="register.php">

Register Sekarang

</a>

</div>

<div class="footer">

© 2026 Smart Emergency Tracker • Secure Access

</div>

</div>

</body>
</html>