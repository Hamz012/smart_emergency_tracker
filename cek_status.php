<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,

"

SELECT * FROM laporan

WHERE id='$id'

LIMIT 1

"

);

$data =
mysqli_fetch_assoc($query);

echo json_encode($data);

?>