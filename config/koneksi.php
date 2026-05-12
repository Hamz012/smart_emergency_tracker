<?php

$conn = mysqli_connect(

    'kodama.proxy.rlwy.net',
    'root',
    'VMQqgajQfCKnUlFeZvmBrkVHdrquaxpu',
    'railway',
    13560

);

if (!$conn) {

    die('Koneksi gagal: ' . mysqli_connect_error());

}

?>