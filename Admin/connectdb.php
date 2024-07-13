<?php
    //session_start();
    $servername = "127.0.0.1:3308";
    $username = "root";
    $password = "";
    $dbname = "cdkt_tdkhenthuong";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Ket noi csdl bi loi: " . $conn->connect_error);
    }

?>