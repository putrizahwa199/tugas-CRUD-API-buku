<?php
    include "../koneksi1.php";


    header("Content-Type: application/json; charset=UTF-8");

    $isbn           = $_POST['isbn'];
    $judul          = $_POST['judul'];
    $pengarang      = $_POST['pengarang'];
    $jumlah         = $_POST['tanggal'];
    $tanggal        = $_POST['tanggal'];
    $abstrak        = $_POST['abstrak'];

    $query =  "INSERT INTO `daftarbuku`(`ISBN`, `JUDUL`, `PENGARANG`, `JUMLAH`, `TANGGAL`, `ABSTRAK`) VALUES ('$isbn','$judul','$pengarang','$jumlah','$tanggal','$abstrak')";
    $execute = $koneksi->query($query);
    $response = [];



    if ($execute) {
        $response['status'] = 'succcess';
        $response['message'] = 'data berhasil ditambahkan';
    } else {
        $response['status'] = 'failed';
        $response['message'] = 'data gagal ditambahkan';
    }
    $json = json_encode($response, JSON_PRETTY_PRINT);
    echo $json;

    ?>