<?php
include 'header.php';
include 'config.php'; // ASUMSI: File ini menyediakan variabel $link untuk koneksi mysqli prosedural

// Cek apakah user sudah login sebagai Pasien
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pasien') {
    header("location: login.php");
    exit;
}

$layanan_err = $tanggal_err = $waktu_err = "";
$layanan = $tanggal = $waktu = $catatan = "";
$success_message = "";
$error_message = "";

// Mengolah data form ketika di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validasi Layanan
    if (empty(trim($_POST["layanan"]))) {
        $layanan_err = "Mohon pilih jenis layanan.";
    } else {
        $layanan = trim($_POST["layanan"]);
    }

    // 2. Validasi Tanggal
    if (empty(trim($_POST["tanggal"]))) {
        $tanggal_err = "Mohon masukkan tanggal janji temu.";
    } else {
        $tanggal = trim($_POST["tanggal"]);
       
        // --- VALIDASI TAMBAHAN: Tanggal harus hari ini atau di masa depan ---
        if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
            $tanggal_err = "Tanggal janji temu harus hari ini atau di masa depan.";
        }
    }

    // 3. Validasi Waktu
    if (empty(trim($_POST["waktu"]))) {
        $waktu_err = "Mohon masukkan waktu janji temu.";
    } else {
        $waktu = trim($_POST["waktu"]);
    }

    // 4. Catatan (Opsional)
    $catatan = trim($_POST["catatan"]);

    // Cek error input sebelum menyimpan ke database
    if (empty($layanan_err) && empty($tanggal_err) && empty($waktu_err)) {

        if (empty($catatan)) {
    $catatan = null;
}


        if ($link === false) {
            $error_message = "ERROR: Koneksi database bermasalah. Silakan hubungi administrator.";
        } else {

            // SQL: Query memiliki 5 placeholder '?' yang perlu di-bind.
            $sql = "INSERT INTO appointments (pasien_id, layanan_id, tanggal_janji, waktu_janji, catatan, status) VALUES (?, ?, ?, ?, ?, 'Pending')";

            if ($stmt = mysqli_prepare($link, $sql)) {

                $layanan_id = (int)$layanan;
                $pasien_id = $_SESSION['user_id'];
               
                // 🔥 PERBAIKAN BARIS 66 🔥
// Tipe data: "iiss" (5 elemen) karena 5 variabel di-bind
                mysqli_stmt_bind_param($stmt, "iisss", $pasien_id, $layanan_id, $tanggal, $waktu, $catatan);

                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Janji Temu Anda berhasil diajukan. Mohon tunggu konfirmasi dari Admin.";
                    // Reset input setelah sukses
                    $layanan = $tanggal = $waktu = $catatan = "";
                } else {
                    $error_message = "Gagal menyimpan janji temu ke database. Error: " . mysqli_error($link);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error_message = "ERROR: Persiapan statement SQL gagal. " . mysqli_error($link);
            }
        }
    }

    
}
?>

<section class="auth-page">
    <div class="auth-container large-form">
        <h2 style="text-align: center;">Buat Janji Temu</h2>
        <p style="text-align: center;">Anda membuat janji temu sebagai: <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>

        <?php if (!empty($success_message)): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="auth-form">

            <div class="form-group">
                <label>Pilih Layanan</label>
                <select name="layanan" class="form-control <?php echo (!empty($layanan_err)) ? 'is-invalid' : ''; ?>">
                    <option value="">-- Pilih salah satu --</option>
                    <option value="1" <?php echo $layanan == '1' ? 'selected' : ''; ?>>Pemasangan Behel</option>
                    <option value="2" <?php echo $layanan == '2' ? 'selected' : ''; ?>>Pembersihan Karang Gigi</option>
                    <option value="3" <?php echo $layanan == '3' ? 'selected' : ''; ?>>Pencabutan Gigi</option>
                    <option value="4" <?php echo $layanan == '4' ? 'selected' : ''; ?>>Tambal Gigi Estetika</option>
                    <option value="5" <?php echo $layanan == '5' ? 'selected' : ''; ?>>Gigi Palsu</option>
                    <option value="5" <?php echo $layanan == '5' ? 'selected' : ''; ?>>Konsultasi</option>
                </select>
                <span class="error-message" style="display: block; margin-top: 5px;"><?php echo $layanan_err; ?></span>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Tanggal Janji Temu</label>
                    <input type="date" name="tanggal" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($tanggal); ?>" class="form-control <?php echo (!empty($tanggal_err)) ? 'is-invalid' : ''; ?>">
                    <span class="error-message" style="display: block; margin-top: 5px;"><?php echo $tanggal_err; ?></span>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Waktu Janji Temu (Format 24 Jam)</label>
                    <input type="time" name="waktu" value="<?php echo htmlspecialchars($waktu); ?>" class="form-control <?php echo (!empty($waktu_err)) ? 'is-invalid' : ''; ?>">
                    <span class="error-message" style="display: block; margin-top: 5px;"><?php echo $waktu_err; ?></span>
                </div>
            </div>

            <div class="form-group">
                <label>Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" rows="3" class="form-control"><?php echo htmlspecialchars($catatan); ?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" class="btn-primary-nav btn-large" value="Kirim Permintaan Janji" style="width: 100%;">
            </div>
        </form>
    </div>
</section>

<?php
// Tutup koneksi di akhir file
if (isset($link)) {
    mysqli_close($link);
}
include 'footer.php';
?>