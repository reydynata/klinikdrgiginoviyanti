<?php
include 'header.php';
include 'config.php'; // Digunakan untuk koneksi database jika Anda ingin menampilkan layanan secara dinamis
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Perawatan Terbaik, Hasil Memuaskan</h1>
            <p>Layanan perawatan gigi dan pembuatan alat ortodontik profesional yang fokus pada senyum sehat dan percaya diri Anda.</p>
            <a href="appointment.php" class="btn-primary-nav btn-large">Buat Janji Sekarang</a>
        </div>
    </div>
</section>

<section class="services-preview section-padding">
    <div class="container">
        <h2 class="centered-heading">Layanan Unggulan Kami</h2>
        <p class="subtitle">Kami menawarkan berbagai layanan terbaik untuk kesehatan dan estetika gigi Anda.</p>

        <div class="services-grid">

            <div class="service-card">
                <i class="fas fa-soap service-icon"></i>
                <h3>Pembersihan Karang Gigi</h3>
                <p>Prosedur penting untuk menghilangkan plak dan karang yang menumpuk di gigi dan gusi.</p>
                <a href="service_detail.php?id=2" class="read-more">Lihat Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <i class="fas fa-teeth service-icon"></i>
                <h3>Pembuatan Gigi Palsu</h3>
                <p>Layanan pembuatan gigi palsu (Gigi Tiruan Lepasan atau Gigi Tiruan Cekat) yang presisi dan nyaman.</p>
                <a href="service_detail.php?id=5" class="read-more">Lihat Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <i class="fas fa-brush service-icon"></i>
                <h3>Tambal Gigi Estetika</h3>
                <p>Mengisi gigi berlubang menggunakan bahan sewarna gigi (composite) agar tampilan tetap alami.</p>
                <a href="service_detail.php?id=4" class="read-more">Lihat Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>

        </div>

        <div class="centered-heading" style="margin-top: 40px;">
            <a href="layanan.php" class="btn-small">Lihat Semua Layanan</a>
        </div>

    </div>
</section>

<section class="section-padding" style="background-color: var(--background-light);">
    <div class="container about-flex-container choose-us-flex" style="align-items: center;">
        <div class="about-text choose-us-content">
            <h2>Mengapa Memilih Klinik Kami?</h2>
            <ul class="clean-list"> <li style="margin-bottom: 10px; font-size: 1.1em;"><i class="fas fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Tim Profesional Bersertifikat</li>
                <li style="margin-bottom: 10px; font-size: 1.1em;"><i class="fas fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Teknologi Modern dan Mutakhir</li>
                <li style="margin-bottom: 10px; font-size: 1.1em;"><i class="fas fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Kenyamanan dan Kebersihan Terjamin</li>
                <li style="margin-bottom: 10px; font-size: 1.1em;"><i class="fas fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Harga Kompetitif dan Transparan</li>
            </ul>
            <a href="about.php" class="btn-primary-nav" style="margin-top: 20px; display: inline-block;">Pelajari Lebih Lanjut</a>
        </div>
        <div class="about-image choose-us-image">
            <img src="assets/images/why_choose_us.jpg" alt="Peralatan Klinik Gigi" class="about-photo"> 
        </div>
    </div>
</section>

<?php 
if (isset($link)) {
    mysqli_close($link);
}
include 'footer.php'; 
?>