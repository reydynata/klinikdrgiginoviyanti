</main> <footer>
    <div class="container">
        <div class="footer-grid">
            
            <div>
                <h3>Tentang Klinik</h3>
                <p style="color: #ccc;">
                    Kami adalah penyedia layanan perawatan gigi dan ortodontik profesional yang berkomitmen menciptakan senyum sehat dan percaya diri untuk Anda.
                </p>
                <p style="margin-top: 10px; color: #aaa; font-size: 0.85em;">
                    Perawat Gigi & Teknisi: Novi Yanti, AMKG
                </p>
            </div>
            
            <div>
                <h3>Tautan Cepat</h3>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="layanan.php">Layanan</a></li>
                    <li><a href="about.php">Tentang Kami</a></li>
                    <li><a href="appointment.php">Buat Janji Temu</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'pasien'): ?>
                        <li><a href="riwayat.php">Riwayat Janji Temu</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="contact-info">
                <h3>Hubungi Kami</h3>
                <p><i class="fas fa-map-marker-alt"></i> Jl. Yos Sudarso No.68, Rumbai, Pekanbaru</p>
                <p><i class="fas fa-phone"></i> 082170665207</p>
                <p><i class="fas fa-envelope"></i> kliniknoviyanti@email.com</p>
            </div>
            
        </div>
        
        <div class="footer-bottom">
            &copy; <?php echo date("Y"); ?> Klinik Gigi & Perawatan. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

<script>
    // Anda bisa tambahkan script JS di sini jika ada
</script>
</body>
</html>