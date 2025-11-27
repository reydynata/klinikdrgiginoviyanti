<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dokter'){
    header("location: ../admin/login.php");
    exit();
}

include '../config/database.php';

$user_id = $_SESSION['user_id'];
// Ambil data dokter dari tabel dokter
$sql_dokter = "SELECT d.*, u.email 
               FROM dokter d 
               JOIN users u ON d.user_id = u.id 
               WHERE d.user_id = '$user_id'";
$result_dokter = mysqli_query($conn, $sql_dokter);
$dokter = mysqli_fetch_assoc($result_dokter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Dokter - Klinik Drg. Novi Yanti</title>
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
                            <a class="nav-link" href="pasien.php">
                                <i class="fas fa-users"></i> Data Pasien
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="profile.php">
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
                <h2>Profile Dokter</h2>

                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" 
                                       value="<?php echo $dokter['nama_lengkap']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="spesialisasi">Spesialisasi</label>
                                <input type="text" class="form-control" id="spesialisasi" 
                                       value="<?php echo $dokter['spesialisasi']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" 
                                       value="<?php echo $dokter['email']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">No Telepon</label>
                                <input type="text" class="form-control" id="no_telp" 
                                       value="<?php echo $dokter['no_telp']; ?>" readonly>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="enableEdit()">Edit Profile</button>
                            <button type="submit" class="btn btn-success" style="display:none;" id="saveBtn">Simpan</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function enableEdit() {
            document.getElementById('nama').readOnly = false;
            document.getElementById('spesialisasi').readOnly = false;
            document.getElementById('email').readOnly = false;
            document.getElementById('no_telp').readOnly = false;
            document.getElementById('saveBtn').style.display = 'inline-block';
        }
    </script>

    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/fontawesome.js"></script>
</body>
</html>