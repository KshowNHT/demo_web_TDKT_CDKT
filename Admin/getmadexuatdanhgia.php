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
            WHEN (dg.DanhGia = 'Tập Thể Lao Động Xuất Sắc' OR dg.DanhGia = 'Giấy Khen Hiệu Trưởng')
                         AND EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND (dg2.DanhGia = 'Hoàn Thành Xuất Sắc' OR dg2.DanhGia = 'Tập Thể Lao Động Xuất Sắc')
                             AND dg2.Manam = dg.Manam - 1
                         ) AND NOT EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg3
                             WHERE dg.MaKhoa = dg3.MaKhoa
                             AND dg3.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'  
                             AND dg3.Manam < dg.Manam
                         )
    				THEN 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                    WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ')
                         AND NOT EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia IN ('Tập Thể Lao Động Tiên Tiến')
                         ) AND NOT EXISTS (
                                 SELECT 1 
                                 FROM danhgiatt dg3
                                 WHERE dg.MaKhoa = dg3.MaKhoa
                                 AND dg3.DanhGia = 'Tập Thể Lao Động Tiên Tiến' 
                                 AND dg3.Manam < dg.Manam
                             )
    					THEN 'Tập Thể Lao Động Tiên Tiến'
                    WHEN dg.DanhGia IN ('Tập Thể Lao Động Tiên Tiến')
                         AND NOT EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia IN ('Tập Thể Lao Động Xuất Sắc')
                         ) AND EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia IN ('Hoàn Thành Xuất Sắc')
                         )
    					THEN 'Tập Thể Lao Động Xuất Sắc'
                    WHEN dg.DanhGia IN ('Tập Thể Lao Động Tiên Tiến')
                         AND NOT EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia IN ('Giấy Khen Hiệu Trưởng')
                         ) AND EXISTS (
                             SELECT 1 
                             FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ')
                         )
    					THEN 'Giấy Khen Hiệu Trưởng'
                    WHEN dg.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                AND EXISTS (
                    SELECT 1
                    FROM danhgiatt dg3
                    WHERE dg.MaKhoa = dg3.MaKhoa
                    AND dg3.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                    AND dg3.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Tập Thể Lao Động Xuất Sắc')
                    GROUP BY dg3.MaKhoa
                    HAVING COUNT(DISTINCT dg3.Manam) >= 5  -- Thay đổi COUNT thành >= 5
                )
                AND EXISTS (
                    SELECT 1 
                    FROM khethuongkyluattt ktt
                    WHERE dg.MaKhoa = ktt.MaKhoa 
                    AND ktt.KhenThuong = 'Cờ Thi Đua Ủy Ban Nhân Dân'
                    AND ktt.Manam BETWEEN dg.Manam - 4 AND dg.Manam  -- Kiểm tra trong khoảng thời gian 5 năm
                )
                AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiatt dg4 
                    WHERE dg.MaKhoa = dg4.MaKhoa 
                    AND dg4.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                    AND dg4.Manam >= dg.Manam - 4
                )
            THEN 'Bằng Khen Thủ Tướng Chính Phủ'
                WHEN dg.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                        AND EXISTS (
                            SELECT 1
                            FROM danhgiatt dg3
                            WHERE dg.MaKhoa = dg3.MaKhoa
                            AND dg3.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                            AND dg3.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Tập Thể Lao Động Xuất Sắc')
                            GROUP BY dg3.MaKhoa
                            HAVING COUNT(DISTINCT dg3.Manam) >= 5  -- Thay đổi COUNT thành >= 5
                        )
                        AND (
                            EXISTS (
                                SELECT 1 
                                FROM khethuongkyluattt ktt
                                WHERE dg.MaKhoa = ktt.MaKhoa 
                                AND ktt.KhenThuong = 'Cờ Thi Đua Chính Phủ'
                                AND ktt.Manam BETWEEN dg.Manam - 4 AND dg.Manam  -- Kiểm tra trong khoảng thời gian 5 năm
                            )
                            OR (
                                SELECT COUNT(*) 
                                FROM khethuongkyluattt ktt
                                WHERE dg.MaKhoa = ktt.MaKhoa 
                                AND ktt.KhenThuong = 'Cờ Thi Đua Ủy Ban Nhân Dân'
                                AND ktt.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                            ) >= 2
                            OR (
                                EXISTS (
                                    SELECT 1 
                                    FROM khethuongkyluattt ktt1
                                    WHERE dg.MaKhoa = ktt1.MaKhoa 
                                    AND ktt1.KhenThuong = 'Cờ Thi Đua Ủy Ban Nhân Dân'
                                    AND ktt1.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                                )
                                AND EXISTS (
                                    SELECT 1 
                                    FROM khethuongkyluattt ktt2
                                    WHERE dg.MaKhoa = ktt2.MaKhoa 
                                    AND ktt2.KhenThuong = 'Bằng Khen Ủy Ban Nhân Dân'
                                    AND ktt2.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                                )
                            )
                        )AND NOT EXISTS (
                    SELECT 1 
                    FROM danhgiatt dg4 
                    WHERE dg.MaKhoa = dg4.MaKhoa 
                    AND dg4.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                    AND dg4.Manam >= dg.Manam - 4
                )
                    THEN 'Huân Chương Lao Động Hạng Ba'

                    WHEN dg.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                            AND EXISTS (
                                SELECT 1
                                FROM danhgiatt dg3
                                WHERE dg.MaKhoa = dg3.MaKhoa
                                AND dg3.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                                AND dg3.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Tập Thể Lao Động Xuất Sắc')
                                GROUP BY dg3.MaKhoa
                                HAVING COUNT(DISTINCT dg3.Manam) >= 5  -- Kiểm tra liên tục 5 năm
                            )
                            AND (
                                (EXISTS (
                                    SELECT 1 
                                    FROM khethuongkyluattt ktt1
                                    WHERE dg.MaKhoa = ktt1.MaKhoa 
                                    AND ktt1.KhenThuong = 'Cờ Thi Đua Chính Phủ'
                                    AND ktt1.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                                ) 
                                AND EXISTS (
                                    SELECT 1 
                                    FROM khethuongkyluattt ktt2
                                    WHERE dg.MaKhoa = ktt2.MaKhoa 
                                    AND ktt2.KhenThuong = 'Cờ Thi Đua Ủy Ban Nhân Dân'
                                    AND ktt2.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                                ))
                                OR (
                                    SELECT COUNT(*) 
                                    FROM khethuongkyluattt ktt
                                    WHERE dg.MaKhoa = ktt.MaKhoa 
                                    AND ktt.KhenThuong = 'Cờ Thi Đua Ủy Ban Nhân Dân'
                                    AND ktt.Manam BETWEEN dg.Manam - 4 AND dg.Manam
                                ) >= 3
                            )
                        THEN 'Huân Chương Lao Động Hạng Nhì'
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
