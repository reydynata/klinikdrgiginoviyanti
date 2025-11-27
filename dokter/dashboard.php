<?php
session_start();
// Cek session khusus admin area
if(!isset($_SESSION['admin_user_id']) || $_SESSION['admin_role'] != 'dokter'){
    header("location: ../admin/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - Klinik Drg. Novi Yanti</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 bg-dark text-white p-0" style="min-height: 100vh;">
                <div class="p-3 text-center">
                    <h5>Klinik Drg. Novi Yanti</h5>
                    <small>AMKG - Perawat Gigi & Teknisi</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="jadwal.php">Jadwal Praktik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="pasien.php">Data Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="profile.php">Profile Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../admin/logout.php">Logout</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Dashboard Dokter</h2>
                <p>Selamat datang, <strong><?php echo $_SESSION['admin_nama']; ?></strong></p>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5>Pasien Hari Ini</h5>
                                <h3>5</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5>Total Pasien</h5>
                                <h3>156</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="alert alert-info">
                        <strong>Info:</strong> Anda login sebagai <strong>Dokter</strong>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>