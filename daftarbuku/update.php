<?php
include "../koneksi1.php";


header("Content-Type: application/json; charset=UTF-8");

$isbn       = $_POST['isbn'];
$judul      = $_POST['judul'];
$pengarang  = $_POST['pengarang'];
$jumlah     = $_POST['jumlah'];
$tanggal    = $_POST['tanggal'];
$abstrak    = $_POST['abstrak'];

$query =  "UPDATE `daftarbuku` SET `JUDUL`='$judul',`PENGARANG`='$pengarang', `JUMLAH`='$jumlah',`TANGGAL`='$tanggal',`ABSTRAK`='$abstrak' WHERE `ISBN`='$isbn'";
$execute = $koneksi->query($query);
$response = [];



if ($execute) {
    $response['status'] = 'succcess';
    $response['message'] = 'data berhasil diupdate';
} else {
    $response['status'] = 'failed';
    $response['message'] = 'data gagal diupdate';
}
$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;