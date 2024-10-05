<?php
include('./connectdb.php');

// Khởi tạo các biến tìm kiếm và giải mã
$HoTen = isset($_GET['HoTen']) ? urldecode($_GET['HoTen']) : '';

// Bắt đầu câu truy vấn SQL
$sql = "SELECT * FROM thongtincanhan ttcn 
        INNER JOIN khoa k ON ttcn.MaKhoa = k.MaKhoa 
        WHERE 1=1";

// Nếu $HoTen có giá trị, thêm điều kiện lọc theo Họ Tên
if (!empty($HoTen)) {
    $stmt = $conn->prepare("SELECT * FROM thongtincanhan ttcn 
                            INNER JOIN khoa k ON ttcn.MaKhoa = k.MaKhoa 
                            WHERE ttcn.HoTen LIKE ?");
    $searchTerm = '%' . $HoTen . '%';
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT * FROM thongtincanhan ttcn 
                            INNER JOIN khoa k ON ttcn.MaKhoa = k.MaKhoa");
}

// Kiểm tra câu truy vấn SQL
error_log("SQL: " . htmlspecialchars($sql));

// Thực thi truy vấn
$stmt->execute();
$result = $stmt->get_result();

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
