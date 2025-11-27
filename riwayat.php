<?php
include 'header.php'; // Menyertakan header, session_start(), dan styling
include 'config.php'; // Menyertakan koneksi database $link

// --- 1. OTENTIKASI PASIEN ---
// Cek apakah user sudah login dan perannya adalah 'pasien'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pasien') {
    header("location: login.php");
    exit;
}

$pasien_id = $_SESSION['user_id'];
$pasien_name = $_SESSION['user_name'];

// --- 2. LOGIKA FETCH DATA RIWAYAT ---
// Mengambil janji temu HANYA untuk pasien yang sedang login
$sql_fetch = "
    SELECT 
        a.id, 
        l.judul AS nama_layanan, /* Menggunakan 'judul' sesuai struktur tabel layanan Anda */
        a.tanggal_janji, 
        a.waktu_janji, 
        a.catatan, 
        a.status
    FROM 
        appointments a
    JOIN 
        layanan l ON a.layanan_id = l.id
    WHERE 
        a.pasien_id = ?
    ORDER BY 
        a.tanggal_janji DESC, a.waktu_janji DESC";

$result = false;
$error_message = "";

if ($stmt = mysqli_prepare($link, $sql_fetch)) {
    mysqli_stmt_bind_param($stmt, "i", $pasien_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $error_message = "Gagal mengambil data riwayat: " . mysqli_error($link);
    }
    mysqli_stmt_close($stmt);
} else {
    $error_message = "ERROR: Persiapan statement SQL gagal. " . mysqli_error($link);
}
?>

<section class="section-padding">
    <div class="container">
        
        <h2 class="centered-heading" style="color: var(--primary-color);">Riwayat Janji Temu</h2>
        <p class="subtitle">Daftar semua janji temu yang pernah Anda ajukan, <?php echo htmlspecialchars($pasien_name); ?>.</p>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Waktu (WIB)</th>
                    <th>Status</th>
                    <th>Catatan Anda</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status_class = "status-" . strtolower($row['status']);
                ?>
                <tr>
                    <td data-label="ID"><?php echo $row['id']; ?></td>
                    <td data-label="Layanan"><?php echo htmlspecialchars($row['nama_layanan']); ?></td>
                    <td data-label="Tanggal"><?php echo date('d M Y', strtotime($row['tanggal_janji'])); ?></td>
                    <td data-label="Waktu"><?php echo date('H:i', strtotime($row['waktu_janji'])); ?></td>
                    <td data-label="Status"><span class="<?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                    <td data-label="Catatan"><?php echo empty($row['catatan']) ? '-' : htmlspecialchars($row['catatan']); ?></td>
                </tr>
                <?php 
                    }
                } else {
                ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Anda belum memiliki riwayat Janji Temu.</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</section>

<?php 
// Perlu diingat, $link harus ditutup hanya jika sudah dibuka di config.php
if (isset($link)) {
    mysqli_close($link);
}
include 'footer.php'; 
?>