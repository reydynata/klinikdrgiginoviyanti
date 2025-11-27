<?php
// Pastikan sesi dimulai di awal setiap file yang membutuhkan sesi.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Tambahkan file konfigurasi di sini agar variabel sesi seperti user_name dan role tersedia.
// Jika file lain (misal index.php) sudah include config, baris ini opsional.
// include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Gigi & Perawatan - Proyek KP</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

<header>
    <div class="container navbar">
        <a href="index.php" class="logo-link">
            <img src="logo_klinik_baru.png" alt="Logo Klinik Gigi" class="site-logo"> 
        </a>

        <nav>
            <a href="index.php">Beranda</a>
            <a href="layanan.php">Layanan</a> 
            <a href="about.php">Tentang Kami</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                
                <?php if ($_SESSION['role'] === 'pasien'): ?>
                    
                    <a href="riwayat.php">Riwayat</a>
                    <a href="appointment.php" class="btn-primary-nav">Buat Janji</a>
                
                <?php elseif ($_SESSION['role'] === 'dokter'): ?>
                    
                    <a href="dashboard_dokter.php" class="btn-primary-nav">Dashboard Admin</a>
                <?php endif; ?>

                <span class="user-info">
                    Login sebagai: <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo htmlspecialchars(ucwords($_SESSION['role'])); ?>)</strong>
                </span>
                <a href="logout.php" class="btn-logout">Logout</a>
                
            <?php else: ?>
                
                <a href="appointment.php" class="btn-primary-nav">Buat Janji Temu</a>
                <a href="login.php" class="btn-small">Login</a>
                
            <?php endif; ?>
        </nav>
    </div>
</header>