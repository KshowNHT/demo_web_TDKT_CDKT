<?php
ob_start(); // Bắt đầu output buffering

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hủy bỏ tất cả các biến phiên
$_SESSION = array();

// Hủy bỏ phiên cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy bỏ phiên
session_destroy();
header("Location: ../Admin/dangnhap.php");
exit();

ob_end_flush(); // Kết thúc output buffering và gửi nội dung
?>
