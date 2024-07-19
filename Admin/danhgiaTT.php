<?php
include('./Khoa.php');

class DanhgiaTT {
    public $MaDGTT;
    public $MaKhoa;
    public $SoQD;
    public $DanhGia;
    
    // Tiêu chí cho các loại khen thưởng
    private static $awardsCriteria = [
        'TT_LAO_DONG_TIEN_TIEN' => [
            'hoan_thanh_nhiem_vu' => true,
            'ca_nhan_70_phan_tram' => true,
            'ky_luat' => false,
            'dong_y' => true
        ],
        'TT_LAO_DONG_XS' => [
            'hoan_thanh_xuat_sac' => true,
            'ca_nhan_100_phan_tram' => true,
            'ca_nhan_70_phan_tram' => true,
            'ca_nhan_dat_cstdcs' => true,
            'ky_luat' => false,
            'dong_y' => true
        ],
        'GK_Hieu_Truong' => [
            'hoan_thanh_tot_nhiem_vu' => true,
            'ca_nhan_90_phan_tram' => true,
            'ky_luat' => false,
            'dong_y' => true
        ],
       
        'BK_UBNDTP' => [
            '2_nam_hoan_thanh_nhiem_vu' => true,
            'dat_danh_hieu_tap_the' => false,
            'dong_y' => true
        ],
    ];

    // kiểm tra từng tiêu chí
    private static function checkHoanThanhNhiemVu($data) {
        return $data['hoan_thanh_nhiem_vu'];
    }

    private static function checkCaNhan70PhanTram($data) {
        return $data['ca_nhan_70_phan_tram'];
    }

    private static function checkKyLuat($data) {
        return !$data['ky_luat'];
    }

    private static function checkDongY($data) {
        return $data['dong_y'];
    }

    private static function checkHoanThanhXuatSac($data) {
        return $data['hoan_thanh_xuat_sac'];
    }

    private static function checkCaNhan100PhanTram($data) {
        return $data['ca_nhan_100_phan_tram'];
    }

    private static function checkcanhandatcstdcs($data) {
        return $data['ca_nhan_dat_cstdcs'];
    }

    private static function checkHoanThanhTotNhiemVu($data) {
        return $data['hoan_thanh_tot_nhiem_vu'];
    }

    private static function checkCaNhan90PhanTram($data) {
        return $data['ca_nhan_90_phan_tram'];
    }
    
    private static function check2NamHoanThanhNhiemVu($data) {
        return $data['2_nam_hoan_thanh_nhiem_vu'];
    }
    private static function checkDatDanhHieuTapThe($data) {
        return $data['dat_danh_hieu_tap_the'];
    }

    // đánh giá các tiêu chí
    private static function evaluateCriteria($data, $criteria) {
        foreach ($criteria as $key => $value) {
            $checkFunction = 'check' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (!method_exists(__CLASS__, $checkFunction)) {
                throw new Exception("Hàm kiểm tra $checkFunction không tồn tại.");
            }
            if (!call_user_func([__CLASS__, $checkFunction], $data)) {
                return false;
            }
        }
        return true;
    }

    // Lấy danh sách Đánh Giá Tập Thể
    public static function layDanhSach($conn) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')";
        $result = $conn->query($sql);

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }
    //lấy danh sách đánh giá tiên tiến
    public static function laydanhsachdanhgiatientien($conn) {
        $sql = "SELECT * FROM `danhgiatt` WHERE DanhGia = 'TT_LAO_DONG_TIEN_TIEN'";
        $result = $conn->query($sql);

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }
     //lấy danh sách đánh giá xuất sắc
    public static function laydanhsachdanhgiaxs($conn) {
        $sql = "SELECT * FROM `danhgiatt` WHERE DanhGia = 'TT_LAO_DONG_XS'";
        $result = $conn->query($sql);

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }

     //lấy danh sách đánh giá hiệu trưởng
     public static function laydanhsachdanhgiahieutruong($conn) {
        $sql = "SELECT * FROM `danhgiatt` WHERE DanhGia = 'GK_Hieu_Truong'";
        $result = $conn->query($sql);

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }

    //lấy danh sách đánh giá UBNDTP
    public static function laydanhsachdanhgiaubndtp($conn) {
        $sql = "SELECT * FROM `danhgiatt` WHERE DanhGia = 'BK_UBNDTP'";
        $result = $conn->query($sql);

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }
    
    // Lấy Đánh Giá Tập Thể theo ID
    public static function laydgtt($conn, $id) {
        $sql = "SELECT * FROM danhgiatt WHERE MaDGTT = $id";
        $result = mysqli_query($conn, $sql);

        $danhgiatt_obj = new DanhgiaTT();
        $row = mysqli_fetch_assoc($result);
        $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
        $danhgiatt_obj->MaKhoa = Khoa::layKhoa($conn, $row["MaKhoa"]);
        $danhgiatt_obj->SoQD = $row["SoQD"];
        $danhgiatt_obj->DanhGia = $row["DanhGia"];
        return $danhgiatt_obj;
    }

    // Thêm Đánh Giá Tập Thể Tiên Tiến
    public function Themxetdanhgiatttientien($conn, $baseUrl, $data) {
        $message = "Lỗi khi thêm thể loại";

        // Kiểm tra từng loại khen thưởng và đánh giá tiêu chí
        foreach (self::$awardsCriteria as $awardType => $criteria) {
            try {
                if (self::evaluateCriteria($data, $criteria)) {
                    $this->DanhGia = $awardType;
                    break;
                }
            } catch (Exception $e) {
                $message = "Lỗi: " . $e->getMessage();
                header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
                exit();
            }
        }

        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
            exit();
        }

        $sql = "UPDATE danhgiatt SET DanhGia = '$this->DanhGia' WHERE MaDGTT = $this->MaDGTT";

        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $message = "Đánh Giá $this->MaKhoa thành công";
        }
        header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
        exit();
    }

    // Thêm Đánh Giá Tập Thể XS và Hiệu Trưởng
    public function Themxetdanhgiatttxsvahieutruong($conn, $baseUrl, $data) {
        $message = "Lỗi khi thêm thể loại";

        // Kiểm tra từng loại khen thưởng và đánh giá tiêu chí
        foreach (self::$awardsCriteria as $awardType => $criteria) {
            try {
                if (self::evaluateCriteria($data, $criteria)) {
                    $this->DanhGia = $awardType;
                    break;
                }
            } catch (Exception $e) {
                $message = "Lỗi: " . $e->getMessage();
                header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
                exit();
            }
        }

        if (empty($this->DanhGia)) {
            $message = "Khoa $this->MaKhoa Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
            exit();
        }

        $sql = "UPDATE danhgiatt SET DanhGia = '$this->DanhGia' WHERE MaDGTT = $this->MaDGTT";

        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $message = "Đánh Giá $this->MaKhoa thành công";
        }
        if($awardType == "TT_LAO_DONG_XS"){
            header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
        }else{
            header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
        }
        
        exit();
    }

    // Thêm Đánh Giá Tập Thể UBNDTP
    public function Themxetdanhgiattubndtp($conn, $baseUrl, $data) {
        $message = "Lỗi khi thêm thể loại";

        // Kiểm tra từng loại khen thưởng và đánh giá tiêu chí
        foreach (self::$awardsCriteria as $awardType => $criteria) {
            try {
                if (self::evaluateCriteria($data, $criteria)) {
                    $this->DanhGia = $awardType;
                    break;
                }
            } catch (Exception $e) {
                $message = "Lỗi: " . $e->getMessage();
                switch ($this->DanhGia) {
                    case "TT_LAO_DONG_XS":
                        header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                        break;
                    case "GK_Hieu_Truong":
                        header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
                        break;
                    default:
                        header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
                }
                exit();
            }
        }

        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            switch ($this->DanhGia) {
                case "TT_LAO_DONG_XS":
                    header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                    break;
                case "GK_Hieu_Truong":
                    header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
                    break;
                default:
                    header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
            exit();
        }

        $sql = "UPDATE danhgiatt SET DanhGia = '$this->DanhGia' WHERE MaDGTT = $this->MaDGTT";

        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $message = "Đánh Giá $this->MaKhoa thành công";
        } else {
            $message = "Lỗi khi thêm đánh giá: " . mysqli_error($conn);
        }

        header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
        exit();
    }
}

    //Thêm Khoa Vào Xét Đánh Giá
    public function Themdanhgiatt($conn,$baseUrl) {
            
        // Thông báo cần gửi
        $message = "Lỗi khi thêm thể loại";
    

        // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, DanhGia) VALUES ('$this->MaKhoa', '$this->SoQD', '$this->DanhGia')";
        
        // thực thi câu truy vấn và kiểm tra kết quả
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $message = "Đánh Giá $this->MaKhoa thành công";
        }
        // Chuyển hướng trang và truyền thông báo qua URL
        header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
        exit();
    }

    // Cập Nhật Đánh Giá Tập Thể
    public function Suadgtt($conn, $baseUrl) {
        $message = "Lỗi khi Sửa thể loại";
        $sql = "UPDATE danhgiatt SET SoQD = '$this->SoQD', DanhGia = '$this->DanhGia' WHERE MaDGTT = $this->MaDGTT";

        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $message = "Cập Đánh Giá $this->MaKhoa thành công";
        }

        switch ($this->DanhGia) {
            case "TT_LAO_DONG_TIEN_TIEN":
                header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
                break;
            case "TT_LAO_DONG_XS":
                header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                break;
            case "GK_Hieu_Truong":
                header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
                break;
            case "BK_UBNDTP":
                header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
                break;
            default:
                header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
        }
        exit();
    }
}
?>
