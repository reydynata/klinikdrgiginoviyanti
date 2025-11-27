<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("location: login.php");
    exit();
}

include '../config/database.php';

// Ambil data antrian dengan status pending
$sql = "SELECT a.*, p.nama_pasien, p.no_telp 
        FROM antrian a 
        JOIN pasien p ON a.pasien_id = p.id 
        WHERE a.status = 'pending' 
        ORDER BY a.tanggal, a.jam";
$result = mysqli_query($conn, $sql);

// Handle approve/reject
if(isset($_POST['action'])){
    $id = $_POST['id'];
    $action = $_POST['action'];
    
    $sql_update = "UPDATE antrian SET status = '$action' WHERE id = '$id'";
    if(mysqli_query($conn, $sql_update)){
        $success = "Janji temu berhasil diupdate!";
        // Refresh halaman
        header("location: manage-appointments.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Janji Temu - Klinik Drg. Novi Yanti</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Manage Janji Temu</h2>

                <?php if(isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Janji Temu Pending</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Nama Pasien</th>
                                        <th>No Telepon</th>
                                        <th>Keluhan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                                        <td><?php echo $row['jam']; ?></td>
                                        <td><?php echo $row['nama_pasien']; ?></td>
                                        <td><?php echo $row['no_telp']; ?></td>
                                        <td><?php echo $row['keluhan']; ?></td>
                                        <td>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="action" value="approved" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="action" value="rejected" class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>