<?php
//1) buat variabel koneksi database
$host = 'localhost';
$db = 'dbsiak';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

//2)buat data source name(DSN) dan $opt, opsi database
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
];

//3)buat objek koneksi PDO
$dbh = new PDO($dsn, $user, $pass, $opt);
?>
