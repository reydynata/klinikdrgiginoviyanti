<?php
include 'header.php';
include 'config.php';

// ===============================
// 1. OTENTIKASI
// ===============================
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dokter') {
    header("location: login.php");
    exit;
}

$error_message = "";
$success_message = "";

// ===============================
// 2. UPDATE STATUS (CONFIRM / CANCEL)
// ===============================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['appointment_id'])) {

    if (!filter_var($_POST['appointment_id'], FILTER_VALIDATE_INT)) {
        $error_message = "ID tidak valid.";
    } else {
        $appointment_id = (int)$_POST['appointment_id'];

        if ($_POST['action'] === 'confirm') {
            $new_status = 'Confirmed';
        } elseif ($_POST['action'] === 'cancel') {
            $new_status = 'Cancelled';
        } else {
            $error_message = "Aksi tidak valid.";
        }

        if (empty($error_message)) {
            $sql_update = "UPDATE appointments SET status = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($link, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $new_status, $appointment_id);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            header("Location: dashboard_dokter.php");
            exit;
        }
    }
}

// ===============================
// 3. PROSES UPDATE EDIT DATA
// ===============================
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $catatan = $_POST['catatan'];

    $sql_update = "
        UPDATE appointments 
        SET tanggal_janji = ?, waktu_janji = ?, catatan = ?
        WHERE id = ?
    ";

    $stmt = mysqli_prepare($link, $sql_update);
    mysqli_stmt_bind_param($stmt, "sssi", $tanggal, $waktu, $catatan, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard_dokter.php");
    exit;
}

// ===============================
// 4. DELETE DATA
// ===============================
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $sql_delete = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql_delete);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard_dokter.php");
    exit;
}

// ===============================
// 5. AMBIL DATA UNTUK EDIT
// ===============================
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_mode = true;

    $sql_edit = "SELECT * FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql_edit);
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $result_edit = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result_edit);
    mysqli_stmt_close($stmt);
}

// ===============================
// 6. FETCH DATA JANJI TEMU
// ===============================
$sql_fetch = "
    SELECT 
        a.id, 
        u.nama AS pasien_name,
        l.judul AS nama_layanan,
        a.tanggal_janji, 
        a.waktu_janji, 
        a.catatan, 
        a.status
    FROM appointments a
    JOIN users u ON a.pasien_id = u.id
    JOIN layanan l ON a.layanan_id = l.id
    ORDER BY a.tanggal_janji ASC, a.waktu_janji ASC
";

$result = mysqli_query($link, $sql_fetch);
?>

<section class="section-padding">
<div class="container">

<h2 class="centered-heading">Dashboard Dokter/Admin</h2>
<p class="subtitle">Kelola Janji Temu Pasien</p>

<?php if (!empty($error_message)): ?>
<div class="error-message"><?= $error_message; ?></div>
<?php endif; ?>

<!-- ===============================
     FORM EDIT (TAMPILAN DISESUAIKAN)
=============================== -->
<?php if ($edit_mode): ?>
<section class="auth-page" style="padding-top:0;">
    <div class="auth-container large-form">
        <h3 style="text-align:center;">Edit Janji Temu</h3>

        <form method="POST" class="auth-form">
            <input type="hidden" name="id" value="<?= $edit_data['id']; ?>">

            <div style="display:flex; gap:20px;">
                <div class="form-group" style="flex:1;">
                    <label>Tanggal Janji Temu</label>
                    <input type="date" name="tanggal"
                        value="<?= $edit_data['tanggal_janji']; ?>"
                        class="form-control"
                        required>
                </div>

                <div class="form-group" style="flex:1;">
                    <label>Waktu Janji Temu</label>
                    <input type="time" name="waktu"
                        value="<?= $edit_data['waktu_janji']; ?>"
                        class="form-control"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" rows="3" class="form-control"><?= htmlspecialchars($edit_data['catatan']); ?></textarea>
            </div>

            <div class="form-group" style="display:flex; gap:10px;">
                <button type="submit" name="update"
                    class="btn-primary-nav btn-large"
                    style="flex:1;">
                    Simpan Perubahan
                </button>

                <a href="dashboard_dokter.php"
                    class="btn-logout"
                    style="flex:1; text-align:center; line-height:45px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</section>
<?php endif; ?>

<table class="data-table">
<thead>
<tr>
    <th>ID</th>
    <th>Pasien</th>
    <th>Layanan</th>
    <th>Tanggal</th>
    <th>Waktu</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= $row['id']; ?></td>
<td><?= htmlspecialchars($row['pasien_name']); ?></td>
<td><?= htmlspecialchars($row['nama_layanan']); ?></td>
<td><?= date('d M Y', strtotime($row['tanggal_janji'])); ?></td>
<td><?= date('H:i', strtotime($row['waktu_janji'])); ?></td>
<td><?= htmlspecialchars($row['status']); ?></td>
<td>

<?php if ($row['status'] === 'Pending'): ?>
<form method="POST" style="display:inline;">
<input type="hidden" name="appointment_id" value="<?= $row['id']; ?>">
<button type="submit" name="action" value="confirm">Konfirmasi</button>
</form>

<form method="POST" style="display:inline;">
<input type="hidden" name="appointment_id" value="<?= $row['id']; ?>">
<button type="submit" name="action" value="cancel">Batal</button>
</form>
<?php endif; ?>

<a href="?edit=<?= $row['id']; ?>">Edit</a>
<a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus data?')">Hapus</a>

</td>
</tr>
<?php endwhile; ?>

</tbody>
</table>

</div>
</section>

<?php
mysqli_close($link);
include 'footer.php';
?>
