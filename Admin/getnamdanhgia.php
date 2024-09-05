<?php
include('./connectdb.php');

// Khởi tạo các biến tìm kiếm
$Manam = isset($_GET['Manam']) ? $_GET['Manam'] : '';
$SoQD = isset($_GET['SoQD']) ? $_GET['SoQD'] : '';
$TenKhoa = isset($_GET['TenKhoa']) ? $_GET['TenKhoa'] : '';

// Bắt đầu câu truy vấn SQL với điều kiện mặc định là kết nối giữa các bảng
$sql = "SELECT * FROM danhgiatt d 
        INNER JOIN nam n ON d.Manam = n.Manam 
        INNER JOIN khoa k ON d.MaKhoa = k.MaKhoa 
        WHERE 1=1";

// Nếu $Manam có giá trị, thêm điều kiện lọc theo năm
if (!empty($Manam)) {
    $sql .= " AND n.Manam = " . intval($Manam);
}

// Nếu $SoQD có giá trị, thêm điều kiện lọc theo Số Quyết Định
if (!empty($SoQD)) {
    $sql .= " AND d.SoQD LIKE '%" . $conn->real_escape_string($SoQD) . "%'";
}

// Nếu $TenKhoa có giá trị, thêm điều kiện lọc theo Tên Khoa
if (!empty($TenKhoa)) {
    $sql .= " AND k.TenKhoa LIKE '%" . $conn->real_escape_string($TenKhoa) . "%'";
}

// Kiểm tra câu truy vấn SQL
error_log("SQL: " . htmlspecialchars($sql));

$result = $conn->query($sql);

$danhgiattList = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $danhgiattList[] = $row;
    }
}

// Kiểm tra kết quả truy vấn
error_log("Kết quả truy vấn: " . print_r($danhgiattList, true));

echo json_encode($danhgiattList);
?>
