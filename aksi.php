<?php
include 'db_connect.php'; 

// 1. OTENTIKASI DAN OTORISASI
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Hanya Dokter/Admin yang boleh menjalankan aksi ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dokter') {
    header("Location: login.php");
    exit();
}

// 2. TANGKAP PARAMETER DARI URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $appointment_id = intval($_GET['id']);
    $action = $_GET['action'];

    $new_status = '';
    
    // Tentukan status baru berdasarkan aksi
    if ($action == 'confirm') {
        $new_status = 'Confirmed';
    } elseif ($action == 'cancel') {
        $new_status = 'Cancelled';
    } elseif ($action == 'complete') { // <<< AKSI BARU: COMPLETE
        $new_status = 'Completed';
    }

    if (!empty($new_status)) {
        // 3. UPDATE STATUS DI DATABASE
        $sql = "UPDATE appointments SET status = '$new_status' WHERE id = '$appointment_id'";

        if ($conn->query($sql) === TRUE) {
            // Sukses: Redirect kembali ke dashboard dengan pesan sukses
            $message = "success_" . strtolower($new_status);
        } else {
            // Gagal: Redirect kembali dengan pesan error
            $message = "error_db";
        }
    } else {
        // Aksi tidak valid
        $message = "error_action";
    }
} else {
    // Parameter kurang
    $message = "error_param";
}

// Redirect kembali ke dashboard_dokter.php setelah operasi
header("Location: dashboard_dokter.php?msg=" . $message);
exit();
?>