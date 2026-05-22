<?php

session_start();

include 'config/koneksi.php';

header('Content-Type: application/json');

/*
========================================
CEK USER LOGIN
========================================
*/

if(!isset($_SESSION['user_id'])){

    echo json_encode([

        'success' => false,

        'message' => 'User belum login'

    ]);

    exit();

}

$user_id =
$_SESSION['user_id'];

/*
========================================
AMBIL DATA
========================================
*/

$latitude =
$_POST['latitude'] ?? '';

$longitude =
$_POST['longitude'] ?? '';

$kecepatan =
$_POST['speed'] ?? 0;

$laporan_id =
$_POST['laporan_id'] ?? '';

$reconnect_token =
$_POST['reconnect_token'] ?? '';

/*
========================================
VALIDASI GPS
========================================
*/

if(
$latitude == '' ||
$longitude == ''
){

    echo json_encode([

        'success' => false,

        'message' => 'GPS tidak ditemukan'

    ]);

    exit();

}

/*
========================================
TOKEN
========================================
*/

if(!$reconnect_token){

    $reconnect_token =
    md5(time().rand());

}

/*
========================================
CEK LAPORAN AKTIF USER
========================================
*/

$cekLaporan = mysqli_query($conn,

"

SELECT *

FROM laporan

WHERE user_id='$user_id'

AND status!='Laporan Selesai'

LIMIT 1

"

);

$dataLaporan =
mysqli_fetch_assoc(
$cekLaporan
);

/*
========================================
JIKA SUDAH ADA LAPORAN AKTIF
========================================
*/

if($dataLaporan){

    $laporan_id =
    $dataLaporan['id'];

    /*
    ========================================
    UPDATE REALTIME
    ========================================
    */

    $update = mysqli_query($conn,

    "

    UPDATE laporan

    SET

    latitude='$latitude',
    longitude='$longitude',
    kecepatan='$kecepatan'

    WHERE id='$laporan_id'

    "

    );

    if(!$update){

        echo json_encode([

            'success' => false,

            'message' => mysqli_error($conn)

        ]);

        exit();

    }

}

/*
========================================
JIKA BELUM ADA LAPORAN
========================================
*/

else{

    /*
    ========================================
    INSERT BARU
    ========================================
    */

    $insert = mysqli_query($conn,

    "

    INSERT INTO laporan(

    user_id,
    latitude,
    longitude,
    kecepatan,
    status,
    reconnect_token

    )

    VALUES(

    '$user_id',
    '$latitude',
    '$longitude',
    '$kecepatan',
    'SOS Dikirim',
    '$reconnect_token'

    )

    "

    );

    /*
    ========================================
    CEK ERROR MYSQL
    ========================================
    */

    if(!$insert){

        echo json_encode([

            'success' => false,

            'message' => mysqli_error($conn)

        ]);

        exit();

    }

    $laporan_id =
    mysqli_insert_id($conn);

}

/*
========================================
SUCCESS
========================================
*/

echo json_encode([

    'success' => true,

    'id' => $laporan_id,

    'reconnect_token' =>
    $reconnect_token

]);

?>