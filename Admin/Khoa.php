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
