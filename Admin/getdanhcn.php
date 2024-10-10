<?php
include('./connectdb.php');

// Khởi tạo các biến tìm kiếm và giải mã
$HoTen = isset($_GET['HoTen']) ? urldecode($_GET['HoTen']) : '';
$Manam = isset($_GET['Manam']) ? $_GET['Manam'] : '';
$SoQD = isset($_GET['SoQD']) ? $_GET['SoQD'] : '';

// Bắt đầu câu truy vấn SQL
$sql = "SELECT * FROM danhgiacn dgcn 
        INNER JOIN khoa k ON dgcn.MaKhoa = k.MaKhoa
        INNER JOIN nam n ON dgcn.Manam = n.Manam
        INNER JOIN thongtincanhan ttcn ON dgcn.MaCN = ttcn.MaCN
        WHERE 1=1";

// Nếu $HoTen có giá trị, thêm điều kiện lọc theo Họ Tên
if (!empty($HoTen)) {
    $stmt = $conn->prepare("SELECT * FROM danhgiacn dgcn 
                            INNER JOIN khoa k ON dgcn.MaKhoa = k.MaKhoa
                            INNER JOIN nam n ON dgcn.Manam = n.Manam
                            INNER JOIN thongtincanhan ttcn ON dgcn.MaCN = ttcn.MaCN
                            WHERE ttcn.HoTen LIKE ?");
    $searchTerm = '%' . $HoTen . '%';
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT * FROM danhgiacn dgcn  
                            INNER JOIN khoa k ON dgcn.MaKhoa = k.MaKhoa
                            INNER JOIN nam n ON dgcn.Manam = n.Manam
                            INNER JOIN thongtincanhan ttcn ON dgcn.MaCN = ttcn.MaCN");
}

// Nếu $Manam có giá trị, thêm điều kiện lọc theo năm
if (!empty($Manam)) {
    $sql .= " AND n.Manam = ?";
    $stmt->bind_param("i", $Manam); // Ràng buộc giá trị Manam là một số nguyên
}


// Nếu $SoQD có giá trị, thêm điều kiện lọc theo Số Quyết Định
if (!empty($SoQD)) {
    $sql .= " AND dgcn.SoQD LIKE '%" . $conn->real_escape_string($SoQD) . "%'";
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
