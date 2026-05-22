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

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(
    135deg,
    #0f172a,
    #14532d,
    #22c55e
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

    animation:float 6s ease-in-out infinite;

}

.bg1{

    width:300px;
    height:300px;

    top:-120px;
    left:-120px;

}

.bg2{

    width:250px;
    height:250px;

    bottom:-100px;
    right:-100px;

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
LOGIN BOX
========================= */

.login-box{

    width:100%;
    max-width:430px;

    background:
    rgba(255,255,255,0.12);

    backdrop-filter:blur(15px);

    border:
    1px solid rgba(255,255,255,0.15);

    border-radius:35px;

    padding:45px 35px;

    box-shadow:
    0 20px 60px rgba(0,0,0,0.25);

    position:relative;

    z-index:10;

}

/* =========================
LOGO
========================= */

.logo{

    width:110px;
    height:110px;

    margin:auto;

    border-radius:30px;

    background:
    linear-gradient(
    135deg,
    #22c55e,
    #16a34a
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;

    font-size:50px;

    box-shadow:
    0 15px 35px rgba(34,197,94,0.45);

    margin-bottom:30px;

}

h1{

    color:white;

    text-align:center;

    font-size:34px;

    font-weight:800;

    margin-bottom:10px;

}

.desc{

    text-align:center;

    color:#dcfce7;

    margin-bottom:35px;

    font-size:15px;

    line-height:1.6;

}

/* =========================
ERROR
========================= */

.error{

    background:
    rgba(239,68,68,0.18);

    border:
    1px solid rgba(239,68,68,0.3);

    color:#fecaca;

    padding:15px;

    border-radius:16px;

    margin-bottom:20px;

    text-align:center;

    font-weight:600;

}

/* =========================
INPUT GROUP
========================= */

.input-group{

    margin-bottom:22px;

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

    font-size:18px;

}

input{

    width:100%;

    padding:18px 18px 18px 55px;

    border:none;

    border-radius:18px;

    background:
    rgba(255,255,255,0.15);

    color:white;

    font-size:15px;

    outline:none;

    transition:0.3s;

}

input::placeholder{

    color:#dcfce7;

}

input:focus{

    background:
    rgba(255,255,255,0.2);

    box-shadow:
    0 0 0 3px rgba(255,255,255,0.15);

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

    font-size:17px;

    font-weight:700;

    cursor:pointer;

    transition:0.3s;

    box-shadow:
    0 12px 30px rgba(34,197,94,0.35);

}

button:hover{

    transform:
    translateY(-4px);

}

/* =========================
REGISTER LINK
========================= */

.register{

    margin-top:25px;

    text-align:center;

}

.register a{

    color:#dcfce7;

    text-decoration:none;

    font-weight:700;

    transition:0.3s;

}

.register a:hover{

    color:white;

}

/* =========================
FOOTER
========================= */

.footer{

    text-align:center;

    margin-top:28px;

    color:#dcfce7;

    font-size:14px;

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

        font-size:40px;

        border-radius:24px;

    }

    h1{

        font-size:28px;

    }

    .desc{

        font-size:14px;

    }

    input{

        padding:16px 16px 16px 50px;

        border-radius:16px;

    }

    button{

        padding:16px;

        border-radius:16px;

    }

}

</style>

</head>

<body>

<!-- BACKGROUND -->

<div class="bg-circle bg1"></div>

<div class="bg-circle bg2"></div>

<!-- LOGIN -->

<div class="login-box">

<div class="logo">

<i class="fa-solid fa-user"></i>

</div>

<h1>
Login Pelapor
</h1>

<p class="desc">

Masuk untuk mengakses sistem
Smart Emergency Tracker

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
placeholder="Masukkan nama"
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

<a href="register.php">

<i class="fa-solid fa-user-plus"></i>

Belum punya akun? Register

</a>

</div>

<div class="footer">

© 2026 Smart Emergency Tracker

</div>

</div>

</body>
</html>