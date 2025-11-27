<?php
session_start();
require '../config/database.php';

// Gunakan session name yang berbeda untuk admin area
if (!isset($_SESSION['admin_area'])) {
    session_destroy();
    session_start();
    $_SESSION['admin_area'] = true;
}

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Cek apakah tabel dokter ada
    $check_table = "SHOW TABLES LIKE 'dokter'";
    $table_exists = mysqli_query($conn, $check_table);
    
    if(mysqli_num_rows($table_exists) > 0) {
        $sql = "SELECT u.*, d.nama_lengkap, d.spesialisasi 
                FROM users u 
                LEFT JOIN dokter d ON u.id = d.user_id 
                WHERE u.email = '$email' AND u.role IN ('admin', 'dokter')";
    } else {
        $sql = "SELECT u.*, u.nama as nama_lengkap, 'Dokter Gigi' as spesialisasi 
                FROM users u 
                WHERE u.email = '$email' AND u.role IN ('admin', 'dokter')";
    }
    
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        
        if($password == $data['password']){
            // Gunakan session variable khusus untuk admin area
            $_SESSION['admin_user_id'] = $data['id'];
            $_SESSION['admin_email'] = $data['email'];
            $_SESSION['admin_nama'] = $data['nama'];
            $_SESSION['admin_role'] = $data['role'];
            
            if($data['role'] == 'admin'){
                header("location: dashboard.php");
            } else if($data['role'] == 'dokter') {
                header("location: ../dokter/dashboard.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan atau tidak memiliki akses!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin/Dokter - Klinik Drg. Novi Yanti</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="login-container">
                    <div class="login-header">
                        <h4><i class="fas fa-tooth"></i> Klinik Drg. Novi Yanti</h4>
                        <small>Login Admin & Dokter</small>
                    </div>
                    <div class="p-4">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="noviyanti@klinik.com">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required 
                                       value="password123">
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Test Login:<br>
                                <strong>Dokter:</strong> noviyanti@klinik.com / password123<br>
                                <strong>Admin:</strong> [email admin Anda]
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/fontawesome.js"></script>
</body>
</html>