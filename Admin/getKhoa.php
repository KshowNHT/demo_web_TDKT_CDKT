<?php
include('./connectdb.php');
if (isset($_GET['MaKhoa'])) {
    $MaKhoa = $_GET['MaKhoa'];
    $sql = "SELECT * FROM Khoa WHERE MaKhoa = '$MaKhoa'";
    $result = $conn->query($sql);

    $khoaData = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $khoaData[] = $row;
        }
    }

    echo json_encode($khoaData);
}
?>
