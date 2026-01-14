<?php
$host = "localhost";
$user = "root"; // sesuaikan dengan konfigurasi Laragon
$pass = "";     // kosongkan jika default
$db   = "db_pramuka";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>