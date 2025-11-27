<?php
/* Pengaturan Koneksi Database */
define('DB_SERVER', 'localhost'); // Ganti jika database Anda di server lain
define('DB_USERNAME', 'root');    // Ganti dengan username database Anda
define('DB_PASSWORD', '');        // Ganti dengan password database Anda
define('DB_NAME', 'klinik_gigi'); // Ganti dengan nama database Anda

// Mencoba Koneksi ke Database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek Koneksi
if($link === false){
    die("ERROR: Tidak dapat terhubung ke database. " . mysqli_connect_error());
}

// Set timezone untuk memastikan waktu janji temu benar
date_default_timezone_set('Asia/Jakarta');
?>