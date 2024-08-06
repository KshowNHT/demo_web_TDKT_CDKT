<?php
include('./Khoa.php');
include('./nam.php');

class DanhgiaTT {
    public $MaDGTT;
    public $MaKhoa;
    public $SoQD;
    public $Manam;
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
            'either' => ['2_nam_hoan_thanh_nhiem_vu', 'dat_danh_hieu_tap_the'],
            'dong_y' => true
        ],


        'BK_TTCP' => [
            'duoc_ubnd_tang_bang_khen' => true,
            'either' => ['co_5_nam_hoan_thanh_xuat_sac', 'dat_tap_the_lao_dong_xuat_sac'],
            'co_1_lan_duoc_tang_co_thi_dua' => true,
            'dong_y' => true
        ],

        'Huan_Chuong_Lao_Dong_Hang_Ba' => [
            'duoc_tang_bang_khen_ttcp' => true,
            'either_1' => ['co_5_nam_hoan_thanh_xsnv', 'dat_danh_hieu_ttldxs'],
            'either_2' => ['co_1_lan_duoc_tang_co_thi_dua_cp', 'co_2_lan_duoc_tang_co_thi_dua_ubnd', 'co_1_lan_duoc_tang_co_thi_dua_ubnd'],
            'co_1_lan_duoc_tang_bang_khen' => true,
            'dong_y' => true
        ],

        'Huan_Chuong_Lao_Dong_Hang_Nhi' => [
            'duoc_tang_hcldhb' => true,
            'either_1' => ['co_5_nam_tro_len_hoan_thanh_xsnv', 'danh_hieu_ttldxs'],
            'co_1_lan_nhan_duoc_co_thi_dua_cp' => true,
            'either_2' => ['co_1_lan_duoc_tang_co_thi_dua_ubnd', 'co_3_lan_duoc_tang_co_thi_dua_ubnd'],
            'dong_y' => true
        ],

    ];

    // kiểm tra từng tiêu chí
    private static function checkCriteria($key, $value, $data) {
        if (strpos($key, 'either') === 0) {
            foreach ($value as $eitherKey) {
                if (!empty($data[$eitherKey])) {
                    return true;
                }
            }
            return false;
        }
        return !empty($data[$key]) === $value;
    }

    // đánh giá các tiêu chí
    private static function evaluateCriteria($data, $criteria) {
        foreach ($criteria as $key => $value) {
            if (!self::checkCriteria($key, $value, $data)) {
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
                $nam_obj = Nam::laynam($conn, $row["Manam"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->Manam = $nam_obj->Nam;
                $danhgiatt_obj->DanhGia = $row["DanhGia"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }

    // Lấy danh sách đánh giá theo loại
    private static function layDanhSachDanhGiaTheoLoai($conn, $loai) {
        $sql = "SELECT * FROM `danhgiatt` WHERE DanhGia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $loai);
        $stmt->execute();
        $result = $stmt->get_result();

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
                $nam_obj = Nam::laynam($conn, $row["Manam"]);
                if ($khoa_obj) {
                    $danhgiatt_obj = new DanhgiaTT();
                    $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                    $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                    $danhgiatt_obj->SoQD = $row["SoQD"];
                    $danhgiatt_obj->Manam = $nam_obj->Nam;
                    $danhgiatt_obj->DanhGia = $row["DanhGia"];
                    $danhgiattList[] = $danhgiatt_obj;
                }
            }
        }
        return $danhgiattList;
    }

    public static function laydanhsachdanhgiatientien($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'TT_LAO_DONG_TIEN_TIEN');
    }

    public static function laydanhsachdanhgiaxs($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'TT_LAO_DONG_XS');
    }

    public static function laydanhsachdanhgiahieutruong($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'GK_Hieu_Truong');
    }

    public static function laydanhsachdanhgiaubndtp($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'BK_UBNDTP');
    }

    public static function laydanhsachdanhgiattcp($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'BK_TTCP');
    }

    public static function laydanhsachdanhgiahcldhb($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'Huan_Chuong_Lao_Dong_Hang_Ba');
    }

    public static function laydanhsachdanhgiahcldhn($conn) {
        return self::layDanhSachDanhGiaTheoLoai($conn, 'Huan_Chuong_Lao_Dong_Hang_Nhi');
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
        $danhgiatt_obj->Manam = Nam::laynam($conn, $row["Manam"]);
        $danhgiatt_obj->DanhGia = $row["DanhGia"];
        return $danhgiatt_obj;
    }

    // Thêm Đánh Giá Tập Thể Tiên Tiến
    public function Themxetdanhgiatttientien($conn, $baseUrl, $data) {
        $message = "Lỗi khi thêm thể loại";

        // Kiểm tra và đánh giá tiêu chí
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
    
        // Kiểm tra nếu không có đánh giá nào được gán
        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
            exit();
        }
    
  
    

        // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES ('$this->MaKhoa', '$this->SoQD', '$this->Manam', '$this->DanhGia')";
        
        // thực thi câu truy vấn và kiểm tra kết quả
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
        }else{
            $message = "Đánh Giá $this->MaKhoa Không thành công ";
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
    
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
    
        if ($stmt->execute()) {
            $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
        } else {
            $message = "Lỗi khi thêm đánh giá: " . $stmt->error;
        }
    
        if ($awardType == "TT_LAO_DONG_XS") {
            header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
        } else {
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
                header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                exit();
            }
        }
    
        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
            exit();
        }
    
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
    
        if ($stmt->execute()) {
            $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
        } else {
            $message = "Lỗi khi thêm đánh giá: " . $stmt->error;
        }
    
        header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
        exit();
    }
    

    // Thêm Đánh Giá Tập Thể TTCP
    public function Themxetdanhgiattcp($conn, $baseUrl, $data) {
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
                header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
                exit();
            }
        }
    
        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
            exit();
        }
    
        if (isset($this->MaDGTT) && is_numeric($this->MaDGTT)) {
            // Sử dụng Prepared Statements
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);          
    
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
    
            $stmt->close();
        } else {
            $message = "Mã đánh giá không hợp lệ";
        }
    
        header("Location: $baseUrl?p=danhgiaTTttcpview&message=" . urlencode($message));
        exit();
    }

    // Thêm Đánh Giá Tập Thể Huân chương Lao động hạng Ba
    public function Themxetdanhgiahcldhb($conn, $baseUrl, $data) {
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
                header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
                exit();
            }
        }
    
        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
            exit();
        }
    
        if (isset($this->MaDGTT) && is_numeric($this->MaDGTT)) {
            // Sử dụng Prepared Statements
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);            
    
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
    
            $stmt->close();
        } else {
            $message = "Mã đánh giá không hợp lệ";
        }
    
        header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
        exit();
    }

    // Thêm Đánh Giá Tập Thể Huân_Chương_Lao_Động_Hạng_Nhì
    public function Themxetdanhgiahcldhn($conn, $baseUrl, $data) {
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
                header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
                exit();
            }
        }
    
        if (empty($this->DanhGia)) {
            $message = "Không đủ điều kiện nhận bất kỳ loại khen thưởng nào";
            header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
            exit();
        }
    
        if (isset($this->MaDGTT) && is_numeric($this->MaDGTT)) {
            // Sử dụng Prepared Statements
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);            
    
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
    
            $stmt->close();
        } else {
            $message = "Mã đánh giá không hợp lệ";
        }
    
        header("Location: $baseUrl?p=danhgiaTThcldhnview&message=" . urlencode($message));
        exit();
    }

    //Thêm Khoa Vào Xét Đánh Giá
    public function Themdanhgiatt($conn,$baseUrl) {
            
        // Thông báo cần gửi
        $message = "Lỗi khi thêm thể loại";
    

        // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);            
    
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
        // Chuyển hướng trang và truyền thông báo qua URL
        header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
        exit();
    }

    // Cập Nhật Đánh Giá Tập Thể
    public function Suadgtt($conn, $baseUrl) {
        $message = "Lỗi khi Sửa thể loại";
        // tạo câu truy vấn 
        $stmt = $conn->prepare("UPDATE danhgiatt SET SoQD = ?, Manam = ?, DanhGia = ? WHERE MaDGTT = ?");
        $stmt->bind_param("siss", $this->SoQD,$this->Manam,$this->DanhGia, $this->MaDGTT);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $message = "Sửa Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
        }

        $stmt->close();

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
            case "BK_TTCP":
                header("Location: $baseUrl?p=danhgiaTTttcpview&message=" . urlencode($message));
                break;
            case "Huan_Chuong_Lao_Dong_Hang_Ba":
                header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
                break;
            case "Huan_Chuong_Lao_Dong_Hang_Nhi":
                header("Location: $baseUrl?p=danhgiaTThcldhnview&message=" . urlencode($message));
                break;
            default:
                header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
        }
        exit();
    }

    // Lấy dữ liệu Đánh Giá theo Năm và trả về JSON
    // public static function laydanhgiaTheoNam($conn, $Manam) {
    //     // Chuẩn bị câu lệnh SQL để tránh SQL Injection
    //     $stmt = $conn->prepare("SELECT * FROM danhgiatt WHERE Manam = ? AND DanhGia IN ('Hoàn Thành Xuất', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')");
    //     if ($stmt === false) {
    //         error_log("Prepare failed: " . htmlspecialchars($conn->error));
    //         return;
    //     }

    //     $stmt->bind_param("s", $Manam);
    //     if (!$stmt->execute()) {
    //         error_log("Execute failed: " . htmlspecialchars($stmt->error));
    //         return;
    //     }

    //     $result = $stmt->get_result();

    //     $danhgiattLists = [];
    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $khoa_obj = Khoa::layKhoa($conn, $row["MaKhoa"]);
    //             $nam_obj = Nam::laynam($conn, $row["Manam"]);
    //             $danhgiatt_obj = new DanhgiaTT();
    //             $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
    //             $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
    //             $danhgiatt_obj->SoQD = $row["SoQD"];
    //             $danhgiatt_obj->Manam = $nam_obj->Nam;
    //             $danhgiatt_obj->DanhGia = $row["DanhGia"];

    //             $danhgiattLists[] = $danhgiatt_obj;
    //         }
    //     }

    //     $stmt->close();

    //     // Trả về dữ liệu dưới dạng JSON
    //     header('Content-Type: application/json; charset=utf-8');
    //     echo json_encode($danhgiattLists, JSON_UNESCAPED_UNICODE);
    //     error_log(json_encode($danhgiattLists)); // Thêm dòng này để log dữ liệu JSON
    // }
}

// ob_start();

// if (isset($_GET['Manam'])) {
//     $Manam = $_GET['Manam'];
//     error_log("Received Manam: " . htmlspecialchars($Manam)); // Log giá trị Manam để kiểm tra
//     DanhgiaTT::laydanhgiaTheoNam($conn, $Manam);
// } else {
//     error_log("No Manam parameter found in the request");
// }

// // Đảm bảo buffer output được đóng
// ob_end_clean();
?>