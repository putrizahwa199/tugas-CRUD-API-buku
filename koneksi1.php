<?php
$server     = "localhost";
$username   = "root";
$password   = "";
$db         = "kuliahweb";
$dsn        = "mysql:host={$server};dbname={$db}";

try {
    $koneksi = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
}