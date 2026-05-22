<?php

include 'config/koneksi.php';

if(isset($_POST['register'])){

    $nama =
    mysqli_real_escape_string(
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

        $error =
        'Nama sudah terdaftar';

    }else{

        mysqli_query($conn,

        "

        INSERT INTO users(nama)

        VALUES('$nama')

        "

        );

        header(
        'Location: login_user.php'
        );

    }

}

?>

<!DOCTYPE html>
<html>
<head>

<title>
Register User
</title>

<style>

body{

    background:#eff6ff;

    display:flex;
    justify-content:center;
    align-items:center;

    height:100vh;

    font-family:Arial;

}

.box{

    background:white;

    padding:40px;

    border-radius:20px;

    width:350px;

}

input{

    width:100%;

    padding:15px;

    margin-bottom:15px;

}

button{

    width:100%;

    padding:15px;

    border:none;

    background:#2563eb;

    color:white;

    border-radius:10px;

}

.error{

    color:red;

    margin-bottom:15px;

}

</style>

</head>

<body>

<div class="box">

<h2>
Register User
</h2>

<?php if(isset($error)){ ?>

<div class="error">

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="nama"
placeholder="Nama"
required>

<button
type="submit"
name="register">

Register

</button>

</form>

</div>

</body>
</html>