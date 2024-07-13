<?php
include('../Admin/connectdb.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['TenTk'])) {
  header("Location: ../Admin/dangnhap.php");
  exit();
}

?>
<h1>Trang chủ  <?php echo $_SESSION['VaiTro']; ?> </h1>