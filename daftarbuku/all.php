<?php
include "../koneksi1.php";
/**
 * @var $koneksi PDO
 */
$query = "SELECT * FROM daftarbuku";

$statement = $koneksi->query($query);
$statement->setFetchMode(PDO::FETCH_OBJ);

$results = $statement->fetchAll();
header('Content-type: application/json');

echo json_encode($results);