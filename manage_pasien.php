<?php
include 'db_connect.php'; 

// 1. OTENTIKASI DAN OTORISASI
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Hanya Dokter/Admin yang boleh mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dokter') {
    header("Location: login.php");
    exit();
}

$message = '';
$edit_data = null; 

// TANGANI POST REQUEST (Tambah/Edit Pasien)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $password_raw = $_POST['password'];
    $pasien_id = isset($_POST['pasien_id']) ? intval($_POST['pasien_id']) : 0;

    if ($pasien_id > 0) {
        // UPDATE (Ubah) Pasien
        $password_update = '';
        if (!empty($password_raw)) {
            // Jika password diisi, hash password baru
            $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);
            $password_update = ", password='$password_hashed'";
        }
        
        $sql = "UPDATE users SET nama='$nama', email='$email' $password_update WHERE id='$pasien_id' AND role='pasien'";
        $action = "diperbarui";
    } else {
        // CREATE (Tambah) Pasien Baru (Harus ada password)
        if (empty($password_raw)) {
             $message = "<div class='error-message'>Password wajib diisi untuk pasien baru.</div>";
             goto skip_db_op; // Lompat ke bagian tampilkan data
        }
        $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password_hashed', 'pasien')";
        $action = "ditambahkan";
    }

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='success-message'>Data Pasien berhasil $action.</div>";
    } else {
        $message = "<div class='error-message'>Error: " . $conn->error . "</div>";
    }
}
skip_db_op:

// TANGANI GET REQUEST (Edit atau Hapus)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($_GET['action'] == 'delete') {
        // DELETE (Hapus) Pasien
        $sql = "DELETE FROM users WHERE id='$id' AND role='pasien'";
        if ($conn->query($sql) === TRUE) {
            $message = "<div class='success-message'>Data Pasien berhasil dihapus.</div>";
            header("Location: manage_pasien.php");
            exit();
        } else {
            $message = "<div class='error-message'>Error menghapus pasien: " . $conn->error . "</div>";
        }

    } elseif ($_GET['action'] == 'edit') {
        // READ (Ambil) data untuk di Edit
        $sql = "SELECT id, nama, email FROM users WHERE id='$id' AND role='pasien'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $edit_data = $result->fetch_assoc();
        }
    }
}

// READ (Tampilkan) semua pasien
$sql_read = "SELECT id, nama, email FROM users WHERE role='pasien' ORDER BY id DESC";
$result_read = $conn->query($sql_read);

include 'header.php';
?>

<section class="section-padding">
    <div class="container">
        <h1>Manajemen Data Pasien</h1>
        <p>Anda dapat menambah, mengubah detail, atau menghapus akun pasien yang terdaftar.</p>
        
        <?php echo $message; ?>

        <div class="auth-container" style="max-width: 600px; margin: 30px auto;">
            <h2><?php echo $edit_data ? 'Ubah Data Pasien' : 'Tambah Pasien Baru'; ?></h2>
            <form class="auth-form" method="POST" action="manage_pasien.php">
                
                <?php if ($edit_data): ?>
                    <input type="hidden" name="pasien_id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo $edit_data ? htmlspecialchars($edit_data['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password <?php echo $edit_data ? '(Kosongkan jika tidak diubah)' : '*'; ?></label>
                    <input type="password" id="password" name="password" <?php echo $edit_data ? '' : 'required'; ?>>
                </div>

                <button type="submit" class="btn-primary">
                    <?php echo $edit_data ? 'Simpan Perubahan' : 'Tambah Pasien'; ?>
                </button>
            </form>
        </div>

        <h2 style="margin-top: 50px;">Daftar Pasien Terdaftar</h2>
        <?php if ($result_read->num_rows > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result_read->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td style="white-space: nowrap;">
                            <a href="manage_pasien.php?action=edit&id=<?php echo $row['id']; ?>" class="btn-small">Edit</a>
                            <a href="manage_pasien.php?action=delete&id=<?php echo $row['id']; ?>" class="btn-small btn-logout" onclick="return confirm('Yakin ingin menghapus pasien ini? Semua janji temu terkait juga akan hilang.');">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">Belum ada pasien yang terdaftar selain Dokter/Admin.</p>
        <?php endif; ?>

    </div>
</section>

<?php include 'footer.php'; ?>