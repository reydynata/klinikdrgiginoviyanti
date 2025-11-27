<?php 
include 'db_connect.php';
include 'header.php';

// Ambil ID dari URL
$service_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query data
$sql = "SELECT * FROM layanan WHERE id = $service_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Layanan tidak ditemukan'); window.location='layanan.php';</script>";
    exit;
}

$service = $result->fetch_assoc();

// Tentukan gambar (jika belum upload, pakai fallback)
$gambar = !empty($service['gambar']) 
          ? "uploads/layanan/" . $service['gambar'] 
          : "assets/images/default_service.jpg";
?>

<style>
.hero-header {
    width: 100%;
    height: 300px;
    background: url('<?= $gambar ?>') no-repeat center center/cover;
    border-radius: 20px;
    position: relative;
    margin-bottom: 40px;
}
.hero-header .overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.45);
    border-radius: 20px;
}
.hero-header h1 {
    position: absolute;
    bottom: 25px;
    left: 30px;
    color: #fff;
    font-size: 35px;
    font-weight: 700;
}
.detail-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 35px;
}
.detail-card {
    padding: 25px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.sidebar-card {
    padding: 20px;
    background: #fafafa;
    border-radius: 18px;
    border: 1px solid #eee;
}
.cta-btn {
    display: inline-block;
    padding: 12px 25px;
    background: #007bff;
    color: white;
    border-radius: 10px;
    margin-top: 20px;
    text-decoration: none;
    transition: 0.2s;
}
.cta-btn:hover {
    background: #0056c1;
}
.list-check li {
    margin-bottom: 10px;
}
.list-check i {
    color: #28a745;
    margin-right: 10px;
}
@media (max-width: 870px) {
    .detail-container {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="container section-padding">
    
    <div class="hero-header">
        <div class="overlay"></div>
        <h1><?= htmlspecialchars($service['judul']); ?></h1>
    </div>

    <div class="detail-container">
        
        <!-- LEFT CONTENT -->
        <div class="detail-card">
            <h2>Deskripsi Layanan</h2>
            <p style="margin-top: 15px; line-height: 1.7;">
                <?= nl2br(htmlspecialchars($service['deskripsi'])); ?>
            </p>

            <h3 style="margin-top: 25px;">Mengapa Memilih Layanan Ini?</h3>
            <ul class="list-check">
                <li><i class="fas fa-check-circle"></i> Ditangani oleh tenaga profesional AMKG</li>
                <li><i class="fas fa-check-circle"></i> Peralatan lengkap dan modern</li>
                <li><i class="fas fa-check-circle"></i> Prosedur aman & nyaman</li>
                <li><i class="fas fa-check-circle"></i> Konsultasi gratis sebelum tindakan</li>
            </ul>

            <a href="appointment.php" class="cta-btn">Buat Janji Sekarang</a>
        </div>

        <!-- SIDEBAR -->
        <div>
            <div class="sidebar-card">
                <h3>Informasi Singkat</h3>
                <p><strong>Layanan:</strong><br><?= htmlspecialchars($service['judul']); ?></p>
                <p style="margin-top: 10px;"><strong>Penanggung Jawab:</strong><br>Novi Yanti, AMKG</p>
            </div>

            <div class="sidebar-card" style="margin-top: 20px;">
                <h3>Gambar Layanan</h3>
                <img src="<?= $gambar ?>" style="width: 100%; border-radius: 15px;">
            </div>

            <div class="sidebar-card" style="margin-top: 20px; text-align:center;">
                <p>Siap mendapatkan perawatan terbaik?</p>
                <a href="appointment.php" class="cta-btn" style="width:100%; display:block;">Buat Janji</a>
            </div>
        </div>

    </div>
</section>

<?php include 'footer.php'; ?>
