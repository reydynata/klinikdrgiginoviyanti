<?php
include 'db_connect.php'; 

// 1. OTENTIKASI (Hanya Pasien yang Boleh Mengakses)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login dan role-nya adalah pasien
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pasien') {
    // Jika belum login atau bukan pasien, arahkan ke login
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_pasien = htmlspecialchars($_SESSION['user_name']);

// 2. QUERY MENGAMBIL RIWAYAT JANJI TEMU
// Pastikan kolom 'catatan' sudah ada di tabel appointments, jika tidak akan terjadi error
$sql_history = "SELECT 
    id, 
    layanan, 
    tanggal, 
    waktu, 
    status, 
    catatan 
FROM appointments 
WHERE user_id = '$user_id'
ORDER BY tanggal DESC, waktu DESC";

// Query dieksekusi di sini (Baris 31 pada error sebelumnya)
$result_history = $conn->query($sql_history); 

include 'header.php';
?>

<section class="section-padding">
    <div class="container">
        <h1>Profil & Riwayat Janji Temu</h1>
        <p>Selamat datang, **<?php echo $nama_pasien; ?>**. Berikut adalah daftar semua janji temu Anda.</p>
        
        <hr>

        <h2>Riwayat Janji Temu Anda</h2>

        <?php if ($result_history->num_rows > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Waktu (WIB)</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result_history->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['layanan']); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                        
                        <td><?php echo date('H:i', strtotime($row['waktu'])); ?></td> 
                        
                        <td>
                            <?php 
                                $status = $row['status'];
                                echo "<span class='status-" . strtolower($status) . "'>" . ucfirst($status) . "</span>";
                            ?>
                        </td>
                        <td><?php echo !empty($row['catatan']) ? htmlspecialchars($row['catatan']) : '-'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">Anda belum membuat janji temu apapun. Silakan <a href="contact.php">Buat Janji</a> sekarang.</p>
        <?php endif; ?>

    </div>
</section>

<?php include 'footer.php'; ?>