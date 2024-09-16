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
                     AND dg2.DanhGia IN ('TT_LAO_DONG_TIEN_TIEN', 'TT_LAO_DONG_XS', 'GK_Hieu_Truong')
                 ) THEN 'TT_LAO_DONG_TIEN_TIEN'
            WHEN dg.DanhGia = 'TT_LAO_DONG_TIEN_TIEN'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'TT_LAO_DONG_XS'
                 ) THEN 'TT_LAO_DONG_XS'
            WHEN dg.DanhGia = 'TT_LAO_DONG_TIEN_TIEN'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'GK_Hieu_Truong'
                 ) THEN 'GK_Hieu_Truong'
            WHEN dg.DanhGia IN ('TT_LAO_DONG_XS', 'GK_Hieu_Truong')
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'BK_UBNDTP'
                 ) THEN 'BK_UBNDTP'
            WHEN dg.DanhGia = 'BK_UBNDTP'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'BK_TTCP'
                 ) THEN 'BK_TTCP'
            WHEN dg.DanhGia = 'BK_TTCP'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Huan_Chuong_Lao_Dong_Hang_Ba'
                 ) THEN 'Huan_Chuong_Lao_Dong_Hang_Ba'
            WHEN dg.DanhGia = 'Huan_Chuong_Lao_Dong_Hang_Ba'
                 AND NOT EXISTS (
                     SELECT 1 FROM danhgiatt dg2 
                     WHERE dg.MaKhoa = dg2.MaKhoa 
                     AND dg.Manam = dg2.Manam 
                     AND dg2.DanhGia = 'Huan_Chuong_Lao_Dong_Hang_Nhi'
                 ) THEN 'Huan_Chuong_Lao_Dong_Hang_Nhi'
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
