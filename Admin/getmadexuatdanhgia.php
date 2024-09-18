<?php
// Kết nối cơ sở dữ liệu
include('./connectdb.php');

// Lấy tham số từ URL
$TenKhoa = isset($_GET['TenKhoa']) ? $_GET['TenKhoa'] : '';
$Manam = isset($_GET['Manam']) ? $_GET['Manam'] : '';

// Câu truy vấn SQL chính

$sql = "WITH danh_sach AS (
    SELECT 
        k.TenKhoa,
        n.Nam,
        dg.DanhGia,
        CASE 
            WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ')
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia IN ('Tập Thể Lao Động Tiên Tiến', 'Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng')
                 ) THEN 'Tập Thể Lao Động Tiên Tiến'
            WHEN dg.DanhGia = 'Tập Thể Lao Động Tiên Tiến'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Tập Thể Lao Động Xuất Sắc'
                 ) THEN 'Tập Thể Lao Động Xuất Sắc'
            WHEN dg.DanhGia = 'Tập Thể Lao Động Tiên Tiến'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Giấy Khen Hiệu Trưởng'
                 ) THEN 'Giấy Khen Hiệu Trưởng'
            WHEN dg.DanhGia IN ('Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng')
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                 ) THEN 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
            WHEN dg.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                 ) THEN 'Bằng Khen Thủ Tướng Chính Phủ'
            WHEN dg.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                 ) THEN 'Huân Chương Lao Động Hạng Ba'
            WHEN dg.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Huân Chương Lao Động Hạng Nhì'
                 ) THEN 'Huân Chương Lao Động Hạng Nhì'
            ELSE NULL
        END AS 'DeXuatKhenThuong'
    FROM danhgiatt dg
    JOIN khoa k ON dg.MaKhoa = k.MaKhoa
    JOIN nam n ON dg.Manam = n.Manam
)
SELECT 
    TenKhoa,
    Nam,
    DanhGia,
    DeXuatKhenThuong
FROM danh_sach
WHERE DeXuatKhenThuong IS NOT NULL";

// Thêm điều kiện tìm kiếm nếu có
if (!empty($TenKhoa)) {
    $sql .= " AND TenKhoa LIKE '%" . $conn->real_escape_string($TenKhoa) . "%'";
}

if (!empty($Manam)) {
    $sql .= " AND Nam = '" . $conn->real_escape_string($Manam) . "'";
}

// Sắp xếp kết quả theo năm và tên khoa
$sql .= " ORDER BY Nam, TenKhoa";

// Thực hiện truy vấn
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
