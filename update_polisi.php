<?php

include 'config/koneksi.php';

$id =
$_POST['id'];

$latitude =
$_POST['latitude'];

$longitude =
$_POST['longitude'];

$speed =
$_POST['speed'];

$jarak =
$_POST['jarak'];

$estimasi =
$_POST['estimasi'];

mysqli_query($conn,

"

UPDATE laporan

SET

police_latitude='$latitude',
police_longitude='$longitude',
police_speed='$speed',
jarak_polisi='$jarak',
estimasi_waktu='$estimasi'

WHERE id='$id'

"

);

echo json_encode([
'success' => true
]);

?>