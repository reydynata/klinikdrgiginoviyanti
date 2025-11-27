<?php
session_start();
// File ini bertanggung jawab memproses data dari formulir appointment.php

// 1. Cek apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Lakukan Validasi dan Sanitasi Input
    
    // Ambil data dari formulir
    $layanan = trim($_POST['layanan'] ?? '');
    $tanggal = trim($_POST['tanggal'] ?? '');
    $waktu = trim($_POST['waktu'] ?? '');
    $catatan = trim($_POST['catatan'] ?? '');
    
    // Cek ID Pasien (Jika sudah login)
    $pasien_id = $_SESSION['user_id'] ?? null;
    $pasien_name = $_SESSION['user_name'] ?? 'Tamu';
    
    // Validasi Sederhana
    if (empty($layanan) || empty($tanggal) || empty($waktu)) {
        // Jika ada field wajib yang kosong, kembalikan user dengan pesan error
        header("Location: appointment.php?error=Semua kolom wajib (Layanan, Tanggal, Waktu) harus diisi.");
        exit;
    }

    // Validasi Tanggal dan Waktu (Pastikan bukan tanggal/waktu yang sudah lewat)
    $waktu_janji = strtotime($tanggal . ' ' . $waktu);
    if ($waktu_janji < time()) {
        header("Location: appointment.php?error=Tanggal dan waktu janji temu tidak boleh di masa lalu.");
        exit;
    }
    
    // 3. SIMULASI KONEKSI DAN PENYIMPANAN DATA KE DATABASE
    
    /* ================================================================
    >>> AREA INI AKAN DIGANTI DENGAN KODE DATABASE NYATA <<<
    Contoh Kode Nyata (membutuhkan config.php dan koneksi database):
    
    include 'config.php'; // Sertakan file koneksi database
    
    $status = 'Pending';
    $stmt = $pdo->prepare("INSERT INTO appointments (pasien_id, layanan, tanggal, waktu, catatan, status) 
                          VALUES (?, ?, ?, ?, ?, ?)");
                          
    $stmt->execute([$pasien_id, $layanan, $tanggal, $waktu, $catatan, $status]);
    
    $success = $stmt->rowCount() > 0;
    ================================================================
    */

    // --- SIMULASI SUCCESS ---
    $success = true; // Anggap penyimpanan berhasil dalam simulasi ini
    
    // 4. Arahkan Pengguna Berdasarkan Hasil Proses
    
    if ($success) {
        // Jika berhasil, arahkan kembali ke halaman Janji Temu dengan pesan sukses
        // Catatan: Di website nyata, Anda mungkin ingin mengarahkan ke halaman Riwayat/Dashboard Pasien
        header("Location: appointment.php?success=1");
        exit;
    } else {
        // Jika gagal (misalnya karena masalah database), arahkan dengan pesan error
        header("Location: appointment.php?error=Gagal menyimpan janji temu. Silakan coba lagi.");
        exit;
    }

} else {
    // Jika diakses langsung tanpa POST data, arahkan kembali ke formulir
    header("Location: appointment.php");
    exit;
}
?>