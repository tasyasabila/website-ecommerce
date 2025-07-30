<?php
$host = "localhost";
$user = "root"; // sesuaikan username
$password = "123456"; // sesuaikan password
$database = "project-latihan-live"; // ganti dengan nama database Anda

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>