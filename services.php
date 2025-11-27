<?php 
include 'db_connect.php'; 
include 'header.php'; 

// Query untuk mengambil semua layanan
$sql_services = "SELECT * FROM layanan ORDER BY id ASC";
$result_services = $conn->query($sql_services);
?>

<section class="section-padding">
    <div class="container">
        <h2>Semua Layanan Kami</h2>
        <p class="subtitle">Pilih layanan yang Anda butuhkan untuk senyum sehat dan percaya diri.</p>
        
        <div class="services-full-grid">
            <?php if ($result_services->num_rows > 0): ?>
                <?php while($row = $result_services->fetch_assoc()): ?>
                <div class="service-full-card">
                    <i class="<?php echo htmlspecialchars($row['ikon']); ?> service-icon-large"></i>
                    <div class="service-content">
                        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                    </div>
                    <a href="service_detail.php?id=<?php echo $row['id']; ?>" class="btn-small">Lihat Detail</a>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center;">Belum ada layanan yang tersedia saat ini.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php include 'footer.php'; ?>