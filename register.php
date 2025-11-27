<?php
include 'header.php';
include 'config.php'; // Mengandung $link (koneksi database)

// Cek apakah user sudah login, jika iya, redirect ke index
if (isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit;
}

// Inisialisasi variabel input dan error
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
$success_message = ""; 

// Memproses data ketika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- 1. VALIDASI DATA INPUT ---
    
    // Validasi Username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Mohon masukkan username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username hanya boleh mengandung huruf, angka, dan underscore.";
    } else {
        // Cek apakah username sudah ada di database
        // PERBAIKAN: Mengganti user_name menjadi nama
        $sql = "SELECT id FROM users WHERE nama = ?"; 
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Username ini sudah terdaftar.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Ada yang salah. Silakan coba lagi nanti.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validasi Email (asumsi kolom email di database adalah 'email')
    if (empty(trim($_POST["email"]))) {
        $email_err = "Mohon masukkan email.";     
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Format email tidak valid.";
    } else {
        // Cek apakah email sudah ada di database
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "Email ini sudah terdaftar.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validasi Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Mohon masukkan password.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password minimal harus 6 karakter.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validasi Konfirmasi Password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Mohon konfirmasi password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Konfirmasi password tidak cocok.";
        }
    }

    // --- 2. PENYIMPANAN KE DATABASE (SETELAH VALIDASI BERHASIL) ---
    
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // PERBAIKAN: Mengganti user_name menjadi nama pada kolom INSERT
        $sql = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'pasien')";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Binding params: sss untuk (nama, email, password)
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Pendaftaran berhasil! Silakan login untuk membuat janji temu.";
                // Reset input
                $username = $email = $password = $confirm_password = ""; 
            } else {
                echo "<div class='error-message'>ERROR: Gagal menyimpan data user. " . mysqli_error($link) . "</div>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<section class="auth-page">
    <div class="auth-container large-form">
        <h2 style="text-align: center;">Daftar Akun Pasien Baru</h2>
        <p style="text-align: center; color: var(--light-text); margin-bottom: 20px;">
            Buat akun untuk mulai membuat janji temu dengan mudah.
        </p>

        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?php echo $success_message; ?> <a href="login.php" style="font-weight: 600;">Login sekarang</a>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="auth-form">
            
            <div class="form-group">
                <label>Nama Pengguna / Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" 
                       class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="error-message"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" 
                       class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="error-message"><?php echo $email_err; ?></span>
            </div>
            
            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Password</label>
                    <input type="password" name="password" 
                           class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                    <span class="error-message"><?php echo $password_err; ?></span>
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="confirm_password" 
                           class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" required>
                    <span class="error-message"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <input type="submit" class="btn-primary-nav btn-large" value="Daftar Sekarang" style="width: 100%;">
            </div>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Sudah punya akun? <a href="login.php" style="font-weight: 600;">Login di sini</a>
        </p>
    </div>
</section>

<?php 
if (isset($link)) {
    mysqli_close($link);
}
include 'footer.php'; 
?>