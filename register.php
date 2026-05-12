<?php

include 'config/koneksi.php';

if(isset($_POST['register'])){

    $nama = mysqli_real_escape_string(
        $conn,
        $_POST['nama']
    );

    /*
    ========================================
    CEK USER
    ========================================
    */

    $cek = mysqli_query($conn,

    "

    SELECT * FROM users

    WHERE nama='$nama'

    "

    );

    if(mysqli_num_rows($cek) > 0){

        $error = 'Nama sudah terdaftar';

    }else{

        mysqli_query($conn,

        "

        INSERT INTO users(nama)

        VALUES('$nama')

        "

        );

        header('Location: login_user.php');

    }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register User</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    font-family:'Segoe UI', sans-serif;

    background:
    linear-gradient(
    135deg,
    #1e3a8a,
    #2563eb,
    #60a5fa
    );

    overflow:hidden;

    position:relative;

}

/* Background Blur Circle */

body::before{

    content:'';

    position:absolute;

    width:350px;
    height:350px;

    background:rgba(255,255,255,0.15);

    border-radius:50%;

    top:-100px;
    left:-100px;

    filter:blur(10px);

}

body::after{

    content:'';

    position:absolute;

    width:300px;
    height:300px;

    background:rgba(255,255,255,0.12);

    border-radius:50%;

    bottom:-100px;
    right:-100px;

    filter:blur(10px);

}

.box{

    width:400px;

    background:rgba(255,255,255,0.95);

    backdrop-filter:blur(10px);

    border-radius:24px;

    padding:40px;

    box-shadow:
    0 20px 50px rgba(0,0,0,0.15);

    position:relative;
    z-index:1;

}

.logo{

    width:75px;
    height:75px;

    margin:0 auto 20px;

    border-radius:20px;

    background:linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
    );

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:32px;

    color:white;

    box-shadow:
    0 10px 25px rgba(37,99,235,0.35);

}

h2{

    text-align:center;

    color:#111827;

    margin-bottom:10px;

    font-size:30px;

}

.subtitle{

    text-align:center;

    color:#6b7280;

    margin-bottom:30px;

    font-size:14px;

}

.input-group{

    margin-bottom:20px;

}

label{

    display:block;

    margin-bottom:8px;

    color:#374151;

    font-size:14px;

    font-weight:600;

}

input{

    width:100%;

    padding:15px 18px;

    border:1px solid #d1d5db;

    border-radius:14px;

    outline:none;

    font-size:15px;

    transition:0.3s;

    background:#f9fafb;

}

input:focus{

    border-color:#2563eb;

    background:white;

    box-shadow:
    0 0 0 4px rgba(37,99,235,0.15);

}

button{

    width:100%;

    padding:15px;

    border:none;

    border-radius:14px;

    background:linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
    );

    color:white;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

    transition:0.3s;

    box-shadow:
    0 10px 20px rgba(37,99,235,0.25);

}

button:hover{

    transform:translateY(-2px);

    box-shadow:
    0 14px 25px rgba(37,99,235,0.35);

}

.error{

    background:#fee2e2;

    color:#dc2626;

    padding:14px;

    border-radius:12px;

    margin-bottom:20px;

    font-size:14px;

    border:1px solid #fecaca;

}

.login-link{

    text-align:center;

    margin-top:20px;

    font-size:14px;

    color:#6b7280;

}

.login-link a{

    color:#2563eb;

    text-decoration:none;

    font-weight:600;

}

.login-link a:hover{

    text-decoration:underline;

}

/* Responsive */

@media(max-width:450px){

    .box{

        width:90%;
        padding:30px;

    }

}

</style>

</head>

<body>

<div class="box">

    <div class="logo">
        👤
    </div>

    <h2>Register</h2>

    <p class="subtitle">
        Buat akun baru untuk melanjutkan
    </p>

    <?php if(isset($error)){ ?>

    <div class="error">

        <?php echo $error; ?>

    </div>

    <?php } ?>

    <form method="POST">

        <div class="input-group">

            <label>Nama Lengkap</label>

            <input
            type="text"
            name="nama"
            placeholder="Masukkan nama lengkap"
            required>

        </div>

        <button
        type="submit"
        name="register">

        Register

        </button>

    </form>

    <div class="login-link">

        Sudah punya akun?
        <a href="login_user.php">
            Login sekarang
        </a>

    </div>

</div>

</body>
</html>