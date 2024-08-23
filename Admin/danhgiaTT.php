<?php
include('./Khoa.php');
include('./nam.php');

class DanhgiaTT {
    public $MaDGTT;
    public $MaKhoa;
    public $SoQD;
    public $Manam;
    public $nam;
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
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("ssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $stmt->bind_param("ssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá $this->MaKhoa là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
        }
         // Chuyển hướng trang và truyền thông báo qua URL
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
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("ssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $stmt->bind_param("ssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
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
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("ssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $stmt->bind_param("ssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
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
    

            // Sử dụng Prepared Statements
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("ssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $stmt->bind_param("ssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
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
            // Sử dụng Prepared Statements
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("ssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $stmt->bind_param("ssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
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
    
            // Sử dụng Prepared Statements
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("ssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
            $stmt->bind_param("ssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Đánh Giá là $this->DanhGia thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
        }
    
        header("Location: $baseUrl?p=danhgiaTThcldhnview&message=" . urlencode($message));
        exit();
    }

    //Thêm Khoa Vào Xét Đánh Giá
    public function Themdanhgiatt($conn, $baseUrl) {
        // Thông báo cần gửi
        $message = "Lỗi khi thêm đánh giá";
    
        // tạo câu truy vấn để thêm đối tượng đánh giá mới vào cơ sở dữ liệu
        $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
        if (is_array($this->MaKhoa)) {
            $successCount = 0;
            foreach ($this->MaKhoa as $khoa) {
                $stmt->bind_param("siss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $successCount++;
                    }
                }
            }
            if ($successCount > 0) {
                $message = "Đánh Giá thành công cho $successCount khoa";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
            }
        } else {
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



    // Xóa Đánh Giá
    public function XoaDanhGia($conn, $baseUrl) {
        $message = "Lỗi khi Xóa thể loại";
        $sql = "DELETE FROM danhgiatt WHERE MaDGTT = $this->MaDGTT";

        if (mysqli_query($conn, $sql)) {
            $message = "Xóa Đánh Giá thành công";
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


    //Phân Trang Đánh Giá
    public static function layTongSoDanhGia($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá') LIMIT $startFrom, $recordsPerPage";
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


    //Phân trang Lao Động Tiên Tiến
    public static function layTongSoDanhGiaTT($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('TT_LAO_DONG_TIEN_TIEN')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaTTPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('TT_LAO_DONG_TIEN_TIEN') LIMIT $startFrom, $recordsPerPage";
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



    //Phân Trang Lao Đông Xuất Sắc 
    public static function layTongSoDanhGiaxs($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('TT_LAO_DONG_XS')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaxsPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('TT_LAO_DONG_XS') LIMIT $startFrom, $recordsPerPage";
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


    // Phân Trang Giấy Khen Hiệu Trưởng
    public static function layTongSoDanhGiaht($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('GK_Hieu_Truong')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiahtPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('GK_Hieu_Truong') LIMIT $startFrom, $recordsPerPage";
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

    // Phân Trang UBNDTP
    public static function layTongSoDanhGiaubndtp($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('BK_UBNDTP')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaubndtpPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('BK_UBNDTP') LIMIT $startFrom, $recordsPerPage";
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
    


    // Phân Trang Thủ Tướng Chính Phủ
    public static function layTongSoDanhGiattcp($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('BK_TTCP')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiattcp($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('BK_TTCP') LIMIT $startFrom, $recordsPerPage";
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


    // Phân Trang Huân Chương Lao Động Hạng Ba
    public static function layTongSoDanhGiahangba($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Huan_Chuong_Lao_Dong_Hang_Ba')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiahangba($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Huan_Chuong_Lao_Dong_Hang_Ba') LIMIT $startFrom, $recordsPerPage";
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


    // Phân Trang Huân Chương Lao Động Hạng Nhì
    public static function layTongSoDanhGiahangnhi($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Huan_Chuong_Lao_Dong_Hang_Nhi')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiahangnhi($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Huan_Chuong_Lao_Dong_Hang_Nhi') LIMIT $startFrom, $recordsPerPage";
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

    public static function layDanhSachTheonam($conn, $Manam) {
        $sql = "SELECT * FROM danhgiatt d INNER JOIN nam n ON d.Manam = n.Manam WHERE n.Manam = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $Manam);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $danhgiattList = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $row["MaKhoa"];
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->Manam = $row["Manam"];
                $danhgiatt_obj->nam = $row["Nam"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];
    
                $danhgiattList[] = $danhgiatt_obj;
            }
        }
    
        return $danhgiattList;
    }
}


ob_start();
include('./connectdb.php');
if (isset($_GET['Manam'])) {
    $Manam = $_GET['Manam'];

    // Kiểm tra giá trị của $Manam
    error_log("Manam: " . htmlspecialchars($Manam));

    $danhgiattList = DanhgiaTT::layDanhSachTheonam($conn, $Manam);

    // Kiểm tra kết quả truy vấn
    error_log("Kết quả truy vấn: " . print_r($danhgiattList, true));

    echo json_encode($danhgiattList);
} else {
    echo json_encode([]);
}
ob_end_clean();
?>