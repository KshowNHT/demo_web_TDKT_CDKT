<?php
// Kết nối cơ sở dữ liệu
include('./connectdb.php');

// Lấy tham số từ URL
$HoTen = isset($_GET['HoTen']) ? $_GET['HoTen'] : '';
$TenKhoa = isset($_GET['TenKhoa']) ? $_GET['TenKhoa'] : '';
$Manam = isset($_GET['Manam']) ? $_GET['Manam'] : '';

// Câu truy vấn SQL chính
$sql = "WITH danh_sach AS (
        SELECT 
            tc.HoTen,
            k.TenKhoa,
            n.Nam,
            dg.DanhGia,
            CASE 
                -- Bằng khen UBND TP
                WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở')
                AND (
                    SELECT COUNT(DISTINCT n.Manam) 
                    FROM danhgiacn dg5 
                    JOIN nam n ON dg5.Manam = n.Manam
                    WHERE dg5.MaCN = dg.MaCN 
                    AND dg5.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở')
                    AND n.Manam <= dg.Manam
                ) = 2
                AND (
                    SELECT COUNT(*) 
                    FROM sangkien sk 
                    WHERE sk.MaCN = dg.MaCN  
                    AND sk.CapSK IN ('Sáng Kiến Cấp Cơ Sở')
                ) = 2
                AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg3 
                    WHERE dg3.MaCN = dg.MaCN  
                    AND dg3.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                )
                THEN 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                
                -- Chiến sĩ thi đua cơ sở
                WHEN dg.DanhGia = 'Lao Động Tiên Tiến'
                AND EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg2 
                    WHERE dg2.MaCN = dg.MaCN  
                    AND dg2.DanhGia IN ('Hoàn Thành Xuất Sắc')
                )
                AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg3 
                    WHERE dg3.MaCN = dg.MaCN  
                    AND dg3.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                )
                OR EXISTS (
                    SELECT 1 
                    FROM sangkien sk 
                    WHERE sk.MaCN = dg.MaCN  
                    AND sk.CapSK IN ('Cấp Trường', 'Nghiên Cứu Khoa Học')
                )
                AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg3 
                    WHERE dg3.MaCN = dg.MaCN  
                    AND dg3.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                )
                THEN 'Chiến Sĩ Thi Đua Cơ Sở'
                
                -- Lao động tiên tiến
                WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ')
                AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg2 
                    WHERE dg2.MaCN = dg.MaCN  
                    AND dg2.DanhGia = 'Lao Động Tiên Tiến'
                )
                THEN 'Lao Động Tiên Tiến'
                
                -- Giấy khen hiệu trưởng
                WHEN dg.DanhGia = 'Lao Động Tiên Tiến'
                AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg2 
                    WHERE dg2.MaCN = dg.MaCN  
                    AND dg2.DanhGia = 'Giấy Khen Hiệu Trưởng'
                )
                THEN 'Giấy Khen Hiệu Trưởng'
                
                -- Huân chương lao động hạng ba
                WHEN dg.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                AND EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg1 
                    WHERE dg1.MaCN = dg.MaCN
                    AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                )
                AND (
                    SELECT COUNT(DISTINCT n.Manam) 
                    FROM danhgiacn dg2 
                    JOIN nam n ON dg2.Manam = n.Manam
                    WHERE dg2.MaCN = dg.MaCN
                    AND dg2.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở', 'Chiến Sĩ Thi Đua Thành Phố')
                    AND n.Manam >= (
                        SELECT MIN(n1.Manam)
                        FROM danhgiacn dg1
                        JOIN nam n1 ON dg1.Manam = n1.Manam
                        WHERE dg1.MaCN = dg.MaCN
                        AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                    )
                ) >= 5
                AND (
                    SELECT COUNT(*) 
                    FROM danhgiacn dg3
                    WHERE dg3.MaCN = dg.MaCN
                    AND dg3.DanhGia = 'Hoàn Thành Xuất Sắc'
                ) >= 2
                AND EXISTS (
                    SELECT 1 
                    FROM danhgiacn dg4
                    WHERE dg4.MaCN = dg.MaCN
                    AND dg4.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                )
                THEN 'Huân Chương Lao Động Hạng Nhì'
                
                ELSE NULL
            END AS DeXuatKhenThuong
        FROM danhgiacn dg
        JOIN khoa k ON dg.MaKhoa = k.MaKhoa
        JOIN nam n ON dg.Manam = n.Manam
        JOIN thongtincanhan tc ON dg.MaCN = tc.MaCN
        WHERE 
            dg.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Lao Động Tiên Tiến', 'Chiến Sĩ Thi Đua Cơ Sở', 'Chiến Sĩ Thi Đua Thành Phố', 'Bằng Khen Thủ Tướng Chính Phủ', 'Huân Chương Lao Động Hạng Ba')
            AND NOT EXISTS (
                SELECT 1 
                FROM khethuongkyluat kt
                WHERE kt.MaCN = dg.MaCN
            )
    ),
    danh_sach_duoc_khen_thuong AS (
        SELECT DISTINCT 
            k.TenKhoa,
            n.Manam
        FROM danhgiacn dg
        JOIN khoa k ON dg.MaKhoa = k.MaKhoa
        JOIN nam n ON dg.Manam = n.Manam
        WHERE dg.DanhGia IN ('Lao Động Tiên Tiến', 'Chiến Sĩ Thi Đua Cơ Sở', 'Bằng Khen Thủ Tướng Chính Phủ', 'Huân Chương Lao Động Hạng Ba')
    )
    SELECT 
        ds.HoTen,
        ds.TenKhoa,
        ds.Nam,
        ds.DanhGia,
        ds.DeXuatKhenThuong
    FROM danh_sach ds
    LEFT JOIN danh_sach_duoc_khen_thuong dskt 
        ON ds.TenKhoa = dskt.TenKhoa 
        AND ds.Nam = dskt.Manam
    WHERE ds.DeXuatKhenThuong IS NOT NULL
    AND dskt.TenKhoa IS NULL
";

// Thêm điều kiện tìm kiếm nếu có
if (!empty($HoTen)) {
    $sql .= " AND HoTen LIKE '%$HoTen%'";
}
if (!empty($TenKhoa)) {
    $sql .= " AND TenKhoa LIKE '%$TenKhoa%'";
}
if (!empty($Manam)) {
    $sql .= " AND Manam = '$Manam'";
}

// Sắp xếp kết quả theo năm và tên khoa
$sql .= " ORDER BY ds.Nam DESC;";

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
