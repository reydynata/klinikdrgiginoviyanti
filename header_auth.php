<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perawat Gigi & Tekniker Gigi</title> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="navbar container">
        <a href="index.php" class="logo-img">
            <img src="logo_perawat_gigi.png" alt="Logo Perawat Gigi & Tekniker" class="site-logo">
        </a>
    </div>
</header>
<main>