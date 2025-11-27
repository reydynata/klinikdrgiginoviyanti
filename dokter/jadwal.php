<?php
session_start();
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
    <title>Jadwal Praktik - Klinik Drg. Novi Yanti</title>
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
                            <a class="nav-link active" href="jadwal.php">
                                <i class="fas fa-calendar-alt"></i> Jadwal Praktik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pasien.php">
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
                <h2>Jadwal Praktik</h2>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Minggu Ini</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Hari</th>
                                        <th>Tanggal</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Senin</td>
                                        <td>12 Des 2024</td>
                                        <td>08:00</td>
                                        <td>16:00</td>
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    </tr>
                                    <tr>
                                        <td>Selasa</td>
                                        <td>13 Des 2024</td>
                                        <td>09:00</td>
                                        <td>17:00</td>
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    </tr>
                                    <tr>
                                        <td>Rabu</td>
                                        <td>14 Des 2024</td>
                                        <td>08:00</td>
                                        <td>16:00</td>
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    </tr>
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