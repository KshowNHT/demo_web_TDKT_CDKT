<?php
include('./connectdb.php');

if (isset($_GET['Manam'])) {
    $Manam = $_GET['Manam'];

    // Kiểm tra giá trị của $Manam
    error_log("Manam: " . htmlspecialchars($Manam));

    $sql = "SELECT * FROM danhgiacn d INNER JOIN nam n ON d.Manam = n.Manam INNER JOIN khoa k on d.MaKhoa = k.MaKhoa INNER JOIN thongtincanhan ttcn ON d.MaCN = ttcn.MaCN  WHERE n.Manam = $Manam";
    
    // Kiểm tra câu truy vấn SQL
    error_log("SQL: " . htmlspecialchars($sql));

    $result = $conn->query($sql);

    $danhgiacnList = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $danhgiacnList[] = $row;
        }
    }

    // Kiểm tra kết quả truy vấn
    error_log("Kết quả truy vấn: " . print_r($danhgiacnList, true)); // Đổi $danhgiacnListv thành $danhgiacnList

    // Trả về dữ liệu dạng JSON
    header('Content-Type: application/json');
    echo json_encode($danhgiacnList);
} else {
    // Trả về một mảng rỗng nếu không có 'Manam' trong request
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
