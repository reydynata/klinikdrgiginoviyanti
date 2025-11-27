<?php
include 'header.php';
include 'config.php'; // Koneksi database

// Cek jika user sudah login, arahkan ke index
if (isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Proses form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Validasi Input
    if (empty(trim($_POST["username_or_email"]))) {
        $username_err = "Mohon masukkan username atau email.";
    } else {
        $username = trim($_POST["username_or_email"]);
    }
    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Mohon masukkan password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // 2. Verifikasi Kredensial
    if (empty($username_err) && empty($password_err)) {
        
        // QUERY FIX: Menggunakan kolom 'nama' ATAU 'email'
        // Kolom di database: id, nama, email, password, role
        $sql = "SELECT id, nama, email, password, role FROM users WHERE nama = ? OR email = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            
            // Bind parameter
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_email);
            $param_username = $username;
            $param_email = $username; // Mencoba match dengan input sebagai username atau email
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                // Cek apakah user ditemukan
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    
                    // Bind result ke variabel
                    mysqli_stmt_bind_result($stmt, $id, $user_name, $email_db, $hashed_password, $role);
                    
                    if (mysqli_stmt_fetch($stmt)) {
                        
                        // Verifikasi Password menggunakan hash
                        if (password_verify($password, $hashed_password)) {
                            
                            // Password benar, mulai sesi
                            session_start();
                            
                            // Set variabel sesi
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["user_name"] = $user_name; // Mengambil dari kolom 'nama'
                            $_SESSION["role"] = $role;
                            
                            // Arahkan user ke halaman yang sesuai
                            if ($role == 'dokter') {
                                header("location: dashboard_dokter.php");
                            } else {
                                header("location: index.php"); // Pasien ke beranda
                            }
                            exit;
                            
                        } else {
                            // Password salah
                            $login_err = "Username/Email atau password tidak valid.";
                        }
                    }
                } else {
                    // Username/Email tidak ditemukan
                    $login_err = "Username/Email atau password tidak valid.";
                }
            } else {
                echo "Oops! Ada yang salah pada database query. Silakan coba lagi nanti.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Tutup koneksi jika ada error lain
    if (isset($link)) {
        mysqli_close($link);
    }
}
?>

<section class="auth-page">
    <div class="auth-container">
        <h2 style="text-align: center;">Selamat Datang Kembali</h2>
        <p style="text-align: center; color: var(--light-text); margin-bottom: 30px;">
            Masuk untuk membuat janji temu atau mengelola akun Anda.
        </p>

        <?php if (!empty($login_err)): ?>
            <div class="error-message">
                <?php echo $login_err; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post" class="auth-form"> 
            
            <div class="form-group">
                <label>Email atau Username</label>
                <input type="text" name="username_or_email" class="form-control <?php echo (!empty($username_err) || !empty($login_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($username); ?>" required>
                <span class="error-message"><?php echo $username_err; ?></span>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err) || !empty($login_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="error-message"><?php echo $password_err; ?></span>
            </div>
            
            <div class="form-group" style="text-align: center;">
                <input type="submit" class="btn-primary-nav btn-large" value="Login" style="width: 100%;"> 
            </div>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Belum punya akun? <a href="register.php" style="font-weight: 600;">Daftar di sini</a>
        </p>
    </div>
</section>

<?php include 'footer.php'; ?>