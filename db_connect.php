<?php
// Konfigurasi Database
$host = "localhost";
$username = "root"; // Ganti jika username database Anda berbeda
$password = "";     // Ganti jika password database Anda berbeda
$database = "klinik_gigi";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    // Tampilkan error koneksi yang jelas
    die("Koneksi Database Gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>