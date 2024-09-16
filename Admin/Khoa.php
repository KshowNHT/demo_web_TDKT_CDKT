<?php

class Khoa {
    public $MaKhoa;
    public $TenKhoa;
    public $MoTa;

    public static function layDanhSach($conn) {
        $Dskhoa = array();
        $sql = "SELECT * FROM `khoa`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $Khoa_obj = new Khoa();
                $Khoa_obj->MaKhoa = $row["MaKhoa"];
                $Khoa_obj->TenKhoa = $row["TenKhoa"];
                $Khoa_obj->MoTa = $row["MoTa"];
                $Dskhoa[] = $Khoa_obj;
            }
        }

        return $Dskhoa;
    }

    // Lấy thông tin Khoa
    public static function layKhoa($conn, $id) {
        $sql = "SELECT * FROM Khoa WHERE MaKhoa = $id";
        $result = mysqli_query($conn, $sql);

        $Khoa = new Khoa();
        if ($row = mysqli_fetch_assoc($result)) {
            $Khoa->MaKhoa = $row['MaKhoa'];
            $Khoa->TenKhoa = $row['TenKhoa'];
            $Khoa->MoTa = $row["MoTa"];
        }

        return $Khoa;
    }

    // Thêm Khoa
    public function ThemKhoa($conn, $baseUrl) {
        $message = "Lỗi khi thêm thể loại";
        $sql = "INSERT INTO khoa (TenKhoa, MoTa) VALUES ('$this->TenKhoa', '$this->MoTa')";

        if (mysqli_query($conn, $sql)) {
            $message = "Thêm Khoa $this->TenKhoa thành công";
        }

        header("Location: $baseUrl?p=Khoa&message=" . urlencode($message));
        exit();
    }

    // Sửa Khoa
    public function SuaKhoa($conn, $baseUrl) {
        $message = "Lỗi khi Sửa thể loại";
        $sql = "UPDATE khoa SET TenKhoa = '$this->TenKhoa', MoTa = '$this->MoTa' WHERE MaKhoa = $this->MaKhoa";

        if (mysqli_query($conn, $sql)) {
            $message = "Sửa Khoa $this->TenKhoa thành công";
        }

        header("Location: $baseUrl?p=Khoa&message=" . urlencode($message));
        exit();
    }

    // Xóa Khoa
    public function XoaKhoa($conn, $baseUrl) {
        $message = "Lỗi khi Xóa thể loại";
        $sql = "DELETE FROM khoa WHERE MaKhoa = $this->MaKhoa";

        if (mysqli_query($conn, $sql)) {
            $message = "Xóa Khoa $this->TenKhoa thành công";
        }

        header("Location: $baseUrl?p=Khoa&message=" . urlencode($message));
        exit();
    }

    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGia($conn, $year) {
        $sql = "SELECT k.*, n.Nam 
            FROM khoa k 
            INNER JOIN nam n ON n.Manam = ?
            WHERE k.MaKhoa NOT IN (
                SELECT d.MaKhoa 
                FROM danhgiatt d 
                WHERE d.Manam = ? AND d.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')
            )";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $year, $year); // Truyền tham số năm hai lần
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }
    

    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGiaLDTT($conn, $year) {
        $sql = "SELECT k.*, n.Nam
            FROM khoa k
            INNER JOIN nam n ON n.Manam = ?
            LEFT JOIN danhgiatt d ON d.MaKhoa = k.MaKhoa AND d.Manam = n.Manam
            GROUP BY k.MaKhoa, n.Nam
            HAVING SUM(CASE WHEN d.DanhGia = 'TT_LAO_DONG_TIEN_TIEN' THEN 1 ELSE 0 END) = 0
            AND SUM(CASE WHEN d.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ') THEN 1 ELSE 0 END) > 0;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGiaubndtp($conn, $year) {
        $sql = "SELECT k.*, n.Nam
            FROM khoa k
            INNER JOIN nam n ON n.Manam = ?
            LEFT JOIN danhgiatt d ON d.MaKhoa = k.MaKhoa AND d.Manam = n.Manam
            GROUP BY k.MaKhoa, n.Nam  
            HAVING SUM(CASE WHEN d.DanhGia = 'BK_UBNDTP' THEN 1 ELSE 0 END) = 0
            AND SUM(CASE WHEN d.DanhGia IN ('TT_LAO_DONG_XS', 'GK_Hieu_Truong') THEN 1 ELSE 0 END) > 0;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }


    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGiaxsvahieutruong($conn, $year) {
        $sql = "SELECT k.*, n.Nam
            FROM khoa k
            INNER JOIN nam n ON n.Manam = ?
            LEFT JOIN danhgiatt d ON d.MaKhoa = k.MaKhoa AND d.Manam = n.Manam
            GROUP BY k.MaKhoa, n.Nam  
            HAVING SUM(CASE WHEN d.DanhGia = 'TT_LAO_DONG_XS' OR d.DanhGia = 'GK_Hieu_Truong' THEN 1 ELSE 0 END) = 0
            AND SUM(CASE WHEN d.DanhGia = 'TT_LAO_DONG_TIEN_TIEN' THEN 1 ELSE 0 END) > 0;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGiattcp($conn, $year) {
        $sql = "SELECT k.*, n.Nam
            FROM khoa k
            INNER JOIN nam n ON n.Manam = ?
            LEFT JOIN danhgiatt d ON d.MaKhoa = k.MaKhoa AND d.Manam = n.Manam
            GROUP BY k.MaKhoa, n.Nam  
            HAVING SUM(CASE WHEN d.DanhGia = 'BK_TTCP' THEN 1 ELSE 0 END) = 0
            AND SUM(CASE WHEN d.DanhGia IN ('BK_UBNDTP') THEN 1 ELSE 0 END) > 0;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }
    


    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGiahangba($conn, $year) {
        $sql = "SELECT k.*, n.Nam
            FROM khoa k
            INNER JOIN nam n ON n.Manam = ?
            LEFT JOIN danhgiatt d ON d.MaKhoa = k.MaKhoa AND d.Manam = n.Manam
            GROUP BY k.MaKhoa, n.Nam  
            HAVING SUM(CASE WHEN d.DanhGia = 'Huan_Chuong_Lao_Dong_Hang_Ba' THEN 1 ELSE 0 END) = 0
            AND SUM(CASE WHEN d.DanhGia IN ('BK_TTCP') THEN 1 ELSE 0 END) > 0;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    //lấy Khoa chửa có đánh theo từng năm 
    public static function layDanhSachChuaDanhGiahangnhi($conn, $year) {
        $sql = "SELECT k.*, n.Nam
            FROM khoa k
            INNER JOIN nam n ON n.Manam = ?
            LEFT JOIN danhgiatt d ON d.MaKhoa = k.MaKhoa AND d.Manam = n.Manam
            GROUP BY k.MaKhoa, n.Nam  
            HAVING SUM(CASE WHEN d.DanhGia = 'Huan_Chuong_Lao_Dong_Hang_Nhi' THEN 1 ELSE 0 END) = 0
            AND SUM(CASE WHEN d.DanhGia IN ('Huan_Chuong_Lao_Dong_Hang_Ba') THEN 1 ELSE 0 END) > 0;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    //phân trang Khoa
    public static function layTongSokhoa($conn) {
        $sql = "SELECT COUNT(*) FROM khoa";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function laykhoaPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM khoa LIMIT $startFrom, $recordsPerPage";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }


    // Lấy dữ liệu Khoa theo MaKhoa và trả về JSON
    public static function layKhoaTheoMa($conn, $MaKhoa) {
        $sql = "SELECT * FROM Khoa WHERE MaKhoa = '$MaKhoa'";
        $result = $conn->query($sql);

        $khoaData = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $khoaData[] = $row;
            }
        }

        echo json_encode($khoaData);
    }
}

if (isset($_GET['MaKhoa'])) {
    include('./connectdb.php'); // Đảm bảo rằng bạn đã bao gồm tệp kết nối database
    $MaKhoa = $_GET['MaKhoa'];
    Khoa::layKhoaTheoMa($conn, $MaKhoa);
}
?>
