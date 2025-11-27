<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("location: login.php");
    exit();
}

include '../config/database.php';

$pages = ['beranda', 'layanan', 'tentang_kami'];
$current_page = isset($_GET['page']) ? $_GET['page'] : 'beranda';

// Jika form disubmit
if(isset($_POST['save'])){
    $page = $_POST['page'];
    $section = $_POST['section'];
    $content = $_POST['content'];
    
    // Cek apakah data sudah ada
    $check = "SELECT * FROM site_content WHERE page = '$page' AND section = '$section'";
    $result = mysqli_query($conn, $check);
    
    if(mysqli_num_rows($result) > 0){
        // Update
        $sql = "UPDATE site_content SET content = '$content' WHERE page = '$page' AND section = '$section'";
    } else {
        // Insert
        $sql = "INSERT INTO site_content (page, section, content) VALUES ('$page', '$section', '$content')";
    }
    
    if(mysqli_query($conn, $sql)){
        $success = "Konten berhasil disimpan!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Ambil data untuk current page
$sections = [];
$sql_sections = "SELECT section, content FROM site_content WHERE page = '$current_page'";
$result_sections = mysqli_query($conn, $sql_sections);
while($row = mysqli_fetch_assoc($result_sections)){
    $sections[$row['section']] = $row['content'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Konten - Klinik Drg. Novi Yanti</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Konten Website</h2>

                <!-- Tabs -->
                <ul class="nav nav-tabs">
                    <?php foreach($pages as $page): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == $page ? 'active' : ''; ?>" 
                           href="?page=<?php echo $page; ?>">
                            <?php echo ucfirst($page); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active">
                        <?php if(isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <!-- Form untuk setiap section -->
                        <?php if($current_page == 'beranda'): ?>
                        <form method="post">
                            <input type="hidden" name="page" value="beranda">
                            <div class="form-group">
                                <label for="hero">Hero Section (Teks Utama)</label>
                                <textarea class="form-control" id="hero" name="section" rows="3"><?php echo isset($sections['hero']) ? $sections['hero'] : ''; ?></textarea>
                            </div>
                            <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                        </form>
                        <!-- Tambahkan section lain untuk beranda -->
                        <?php elseif($current_page == 'layanan'): ?>
                        <form method="post">
                            <input type="hidden" name="page" value="layanan">
                            <div class="form-group">
                                <label for="layanan_list">Daftar Layanan (HTML diperbolehkan)</label>
                                <textarea class="form-control" id="layanan_list" name="section" rows="10"><?php echo isset($sections['layanan_list']) ? $sections['layanan_list'] : ''; ?></textarea>
                            </div>
                            <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                        </form>
                        <?php elseif($current_page == 'tentang_kami'): ?>
                        <form method="post">
                            <input type="hidden" name="page" value="tentang_kami">
                            <div class="form-group">
                                <label for="tentang_kami_deskripsi">Deskripsi Tentang Kami (HTML diperbolehkan)</label>
                                <textarea class="form-control" id="tentang_kami_deskripsi" name="section" rows="10"><?php echo isset($sections['tentang_kami_deskripsi']) ? $sections['tentang_kami_deskripsi'] : ''; ?></textarea>
                            </div>
                            <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>