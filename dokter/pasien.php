<?php
session_start();
if(!isset($_SESSION['admin_user_id']) || $_SESSION['admin_role'] != 'dokter'){
    header("location: ../admin/login.php");
    exit();
}
?>
include '../config/database.php';

// Ambil data pasien dari tabel users dengan role pasien
$sql_pasien = "SELECT * FROM users WHERE role = 'pasien' ORDER BY created_at DESC";
$result_pasien = mysqli_query($conn, $sql_pasien);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Klinik Drg. Novi Yanti</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: #34495e;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar p-0">
                <div class="sidebar-sticky">
                    <div class="sidebar-header p-3 text-center">
                        <h5>Klinik Drg. Novi Yanti</h5>
                        <small>AMKG - Perawat Gigi & Teknisi</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jadwal.php">
                                <i class="fas fa-calendar-alt"></i> Jadwal Praktik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="pasien.php">
                                <i class="fas fa-users"></i> Data Pasien
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">
                                <i class="fas fa-user-md"></i> Profile Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto p-4">
                <h2 class="mb-4">Data Pasien</h2>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Daftar Pasien</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; while($pasien = mysqli_fetch_assoc($result_pasien)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $pasien['nama']; ?></td>
                                        <td><?php echo $pasien['email']; ?></td>
                                        <td><?php echo date('d M Y', strtotime($pasien['created_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info">Detail</button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/fontawesome.js"></script>
</body>
</html>