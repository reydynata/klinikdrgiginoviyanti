<?php
session_start();
// Hapus session admin area saja
unset($_SESSION['admin_user_id']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_nama']);
unset($_SESSION['admin_role']);
unset($_SESSION['admin_area']);
header("location: login.php");
exit();
?>