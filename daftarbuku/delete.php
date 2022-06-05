<?php
include "../koneksi1.php";


header("Content-Type: application/json; charset=UTF-8");

$isbn = $_POST['isbn'];


$query      =  "DELETE FROM `daftarbuku` WHERE ISBN = $isbn";
$execute    = $koneksi->query($query);
$response   = [];




if ($execute) {
    $response['status']     = 'succcess';
    $response['message']    = 'data berhasil dihapus';
} else {
    $response['status']     = 'failed';
    $response['message']    = 'data gagal dihapus';
}
$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;