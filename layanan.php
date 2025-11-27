<?php
include 'header.php';
include 'config.php'; // Koneksi database

// --- Ambil data layanan dari database ---
// Mengambil semua data layanan, menggunakan kolom 'judul' sesuai struktur tabel Anda.
$sql = "SELECT id, judul, deskripsi, ikon FROM layanan ORDER BY id ASC";
$result = mysqli_query($link, $sql);
$layanan_list = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $layanan_list[] = $row;
    }
}
// Tidak perlu menutup koneksi di sini karena akan ditutup di footer.php jika Anda mau
// atau biarkan dibuka sampai akhir file.
?>

<section class="section-padding">
    <div class="container">
        <h2 class="centered-heading">Semua Layanan Kami</h2>
        <p class="subtitle">Kami menyediakan rangkaian perawatan gigi lengkap, mulai dari pencegahan hingga estetika lanjutan.</p>
        
        <div class="services-full-grid">
            
            <?php if (!empty($layanan_list)): ?>
                <?php foreach ($layanan_list as $layanan): ?>
                    <div class="service-full-card">
                        <div class="service-icon-large"><i class="<?php echo htmlspecialchars($layanan['ikon']); ?>"></i></div>
                        <div class="service-content">
                            <h3><?php echo htmlspecialchars($layanan['judul']); ?></h3>
                            <p><?php echo htmlspecialchars($layanan['deskripsi']); ?></p>
                        </div>
                        <a href="service_detail.php?id=<?php echo $layanan['id']; ?>" class="read-more" style="text-align: right;">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center;">Maaf, belum ada data layanan yang tersedia.</p>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php 
// Tutup koneksi jika belum ditutup di file lain
if (isset($link)) {
    mysqli_close($link);
}
include 'footer.php'; 
?>