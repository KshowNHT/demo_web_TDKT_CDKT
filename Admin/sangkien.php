<?php
include('./thongtincanhan.php');
include('./nam.php');
class sangkien {
    public $MaSK;
    public $MaCN;
    public $Manam;
    public $TenSK;
    public $QD;
    public $CapSK;

    public static function layDanhSach($conn) {
        $Dssangkien = array();
        $sql = "SELECT * FROM sangkien ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
                $nam_obj = Nam::laynam($conn, $row["Manam"]);
                $sangkien_obj = new sangkien();
                $sangkien_obj->MaSK = $row["MaSK"];
                $sangkien_obj->MaCN = $thongtincanhan_obj->HoTen;
                $sangkien_obj->Manam = $nam_obj->Nam;
                $sangkien_obj->TenSK = $row["TenSK"];
                $sangkien_obj->QD = $row["QD"];
                $sangkien_obj->CapSK = $row["CapSK"];
                $Dssangkien[] = $sangkien_obj;
            }
        }

        return $Dssangkien;
    }

    // Lấy thông tin Sáng Kiến
    public static function laysangkien($conn, $id) {
        $sql = "SELECT * FROM sangkien WHERE MaSK = $id";
        $result = mysqli_query($conn, $sql);

        $sangkien_obj = new sangkien();
        if ($row = mysqli_fetch_assoc($result)) {
            $sangkien_obj->MaSK = $row["MaSK"];
            $sangkien_obj->MaCN = $row['MaCN'];
            $sangkien_obj->Manam = $row['Manam'];
            $sangkien_obj->TenSK = $row["TenSK"];
            $sangkien_obj->QD = $row["QD"];
            $sangkien_obj->CapSK = $row["CapSK"];
        }

        return $sangkien_obj;
    }


    // Lấy thông tin Sáng Kiến
    public static function laysangkienct($conn, $id) {
        $sql = "SELECT * FROM sangkien WHERE MaSK = $id";
        $result = mysqli_query($conn, $sql);

        $sangkien_obj = new sangkien();
        if ($row = mysqli_fetch_assoc($result)) {
            $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
            $nam_obj = Nam::laynam($conn, $row["Manam"]);
            $sangkien_obj->MaSK = $row["MaSK"];
            $sangkien_obj->MaCN = $thongtincanhan_obj->HoTen;
            $sangkien_obj->Manam = $nam_obj->Nam;
            $sangkien_obj->TenSK = $row["TenSK"];
            $sangkien_obj->QD = $row["QD"];
            $sangkien_obj->CapSK = $row["CapSK"];
        }

        return $sangkien_obj;
    }

    // Thêm Khoa
    public function Themsangkien($conn, $baseUrl) {
        $message = "Lỗi khi thêm thể loại";
        $sql = "INSERT INTO sangkien (MaCN, Manam, TenSK, QD, CapSK) VALUES ('$this->MaCN', '$this->Manam', '$this->TenSK', '$this->QD', '$this->CapSK')";

        if (mysqli_query($conn, $sql)) {
            $message = "Thêm Sáng Kiên $this->TenSK của $this->MaCN thành công";
        }

        header("Location: $baseUrl?p=sangkien&message=" . urlencode($message));
        exit();
    }

    // Sửa Thông Tin Sáng Kiến
    // public function Suasangkien($conn, $baseUrl) {
    //     $message = "Lỗi khi Sửa thể loại";
    //     $sql = "UPDATE sangkien SET Manam = '$this->Manam', TenSK = '$this->TenSK', QD = '$this->QD',  CapSK = '$this->CapSK' WHERE MaSK = $this->MaSK";

    //     if (mysqli_query($conn, $sql)) {
    //         $message = "Sửa Sáng Kiến $this->TenSK thành công";
    //     }

    //     header("Location: $baseUrl?p=sangkien&message=" . urlencode($message));
    //     exit();
    // }

    public function Suasangkien($conn, $baseUrl) {
        // Kiểm tra các thuộc tính trước khi thực hiện câu lệnh SQL
        if (!isset($this->MaCN) || !isset($this->Manam) || !isset($this->TenSK) || !isset($this->QD) || !isset($this->CapSK) || !isset($this->MaSK)) {
            throw new Exception('Thiếu thông tin cần thiết.');
        }

        // Thực hiện câu lệnh SQL
        $sql = "UPDATE sangkien SET MaCN=?, Manam=?, TenSK=?, QD=?, CapSK=? WHERE MaSK=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new mysqli_sql_exception($conn->error);
        }

        // Ràng buộc các tham số với câu lệnh SQL
        $stmt->bind_param('sssssi', $this->MaCN, $this->Manam, $this->TenSK, $this->QD, $this->CapSK, $this->MaSK);

        // In ra câu lệnh SQL để kiểm tra
        // echo $stmt->error;

        // Thực thi câu lệnh
        if (!$stmt->execute()) {
            throw new mysqli_sql_exception($stmt->error);
        }

        $message = "Sửa Sáng Kiến $this->TenSK thành công";

        // Chuyển hướng sau khi sửa thành công
        header("Location: $baseUrl?p=sangkien&message=" . urlencode($message));
        exit();
    }

    // Xóa Sáng Kiến
    public function Xoasangkien($conn, $baseUrl) {
        $message = "Lỗi khi Xóa thể loại";
        $sql = "DELETE FROM sangkien WHERE MaSK = $this->MaSK";

        if (mysqli_query($conn, $sql)) {
            $message = "Xóa Khoa thành công";
        }

        header("Location: $baseUrl?p=sangkien&message=" . urlencode($message));
        exit();
    }



    public static function layTongSosangkien($conn) {
        $sql = "SELECT COUNT(*) FROM sangkien";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function laysangkienPhanTrang($conn, $startFrom, $recordsPerPage) {
        $Dssangkien = array();
        $sql = "SELECT * FROM sangkien LIMIT $startFrom, $recordsPerPage";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn, $row["MaCN"]);
                $nam_obj = Nam::laynam($conn, $row["Manam"]);
                $sangkien_obj = new sangkien();
                $sangkien_obj->MaSK = $row["MaSK"];
                $sangkien_obj->MaCN = $thongtincanhan_obj->HoTen;
                $sangkien_obj->Manam = $nam_obj->Nam;
                $sangkien_obj->TenSK = $row["TenSK"];
                $sangkien_obj->QD = $row["QD"];
                $sangkien_obj->CapSK = $row["CapSK"];
                $Dssangkien[] = $sangkien_obj;
            }
        }
    
        return $Dssangkien;
    }



    // Lấy dữ liệu sáng kiến theo năm và trả về JSON
    // public static function laysangkienTheoMa($conn, $MaKhoa) {
    //     $sql = "SELECT * FROM Khoa WHERE MaKhoa = '$MaKhoa'";
    //     $result = $conn->query($sql);

    //     $khoaData = [];
    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $khoaData[] = $row;
    //         }
    //     }

    //     echo json_encode($khoaData);
    // }

    // public static function layDanhSachsangkienTheonam($conn, $Manam) {
    //     $sql = "SELECT * FROM sangkien s INNER JOIN nam n ON s.Manam = n.Manam WHERE n.Manam = ?";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("i", $Manam);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    
    //     $sangkienList = [];
    //     if ($result && $result->num_rows > 0) {
    //         while($row = $result->fetch_assoc()) {
    //             $sangkien_obj = new sangkien();
    //             $sangkien_obj->MaSK = $row["MaSK"];
    //             $sangkien_obj->MaCN = $row["MaCN"];
    //             $sangkien_obj->Manam = $row["Manam"];
    //             $sangkien_obj->TenSK = $row["TenSK"];
    //             $sangkien_obj->CapSK = $row["CapSK"];
    //             $sangkien_obj->nam = $row["Nam"];
    //             $sangkien_obj->QD = $row["QD"];
    
    //             $sangkienList[] = $sangkien_obj;
    //         }
    //     }
    
    //     return $sangkienList;
    // }
    


}

// if (isset($_GET['MaKhoa'])) {
//     include('./connectdb.php'); 
//     $MaKhoa = $_GET['MaKhoa'];
//     Khoa::layKhoaTheoMa($conn, $MaKhoa);
// }

// if (isset($_GET['Manam'])) {
//     include('./connectdb.php'); // Đảm bảo rằng bạn đã bao gồm tệp kết nối database
//     $Manam = $_GET['Manam'];
//     sangkien::layDanhSachsangkienTheonam($conn, $Manam);
// }

// ob_start();
// // include('./connectdb.php');
// if (isset($_GET['Manam'])) {
//     $Manam = $_GET['Manam'];

//     // Kiểm tra giá trị của $Manam
//     error_log("Manam: " . htmlspecialchars($Manam));

//     $sangkienList = sangkien::layDanhSachTheonam($conn, $Manam);

//     // Kiểm tra kết quả truy vấn
//     error_log("Kết quả truy vấn: " . print_r($sangkienList, true));

//     echo json_encode($sangkienList);
// } else {
//     echo json_encode([]);
// }
// ob_end_clean();

?>