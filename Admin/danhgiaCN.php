<?php
    include('./thongtincanhan.php');
    include('./nam.php');

    class DanhgiaCN {
        public $MaDGCN;
        public $MaCN;
        public $MaKhoa;
        public $SoQD;
        public $Manam;
        public $DanhGia;
        public $Ngay;
        public $DonVi;


        public static function layDanhSach($conn) 
        {

                // Lấy danh sách Đánh Giá Cá Nhân
            $sql = "SELECT * FROM `danhgiacn` where DanhGia in ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá') ORDER by Manam ASC";
            $result = $conn->query($sql);

            $danhgiacnList = array();
        
            // Kiểm tra số lượng Đánh Giá Cá Nhân trả về
            if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                // Đánh Giá Cá Nhân vào danh sách
                // Tạo đối tượng Khoa và đưa vào mảng
                $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
                $nam_obj = Nam::laynam($conn,$row["Manam"]);
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $danhgiacn_obj = new DanhgiaCN();
                $danhgiacn_obj->MaDGCN = $row["MaDGCN"];
                $danhgiacn_obj->MaCN = $thongtincanhan_obj->HoTen;
                $danhgiacn_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiacn_obj->Manam = $nam_obj->Nam;
                $danhgiacn_obj->SoQD = $row["SoQD"];
                $danhgiacn_obj->DanhGia = $row["DanhGia"];

                $danhgiacnList[] = $danhgiacn_obj;
            }
            }
            return $danhgiacnList;

        }

        public static function ldsskhoa($conn, $id){
            $sql = "SELECT * FROM danhgiacn WHERE MaKhoa = $id ";

            $result = $conn->query($sql);

            $danhgiacnList = array();
        
            // Kiểm tra số lượng Đánh Giá Cá Nhân trả về
            if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                // Đánh Giá Cá Nhân vào danh sách
                // Tạo đối tượng Khoa và đưa vào mảng
                $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
                $nam_obj = Nam::laynam($conn,$row["Manam"]);
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $danhgiacn_obj = new DanhgiaCN();
                $danhgiacn_obj->MaDGCN = $row["MaDGCN"];
                $danhgiacn_obj->MaCN = $thongtincanhan_obj->HoTen;
                $danhgiacn_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiacn_obj->Manam = $nam_obj->Nam;
                $danhgiacn_obj->SoQD = $row["SoQD"];
                $danhgiacn_obj->DanhGia = $row["DanhGia"];

                $danhgiacnList[] = $danhgiacn_obj;
            }
            }
            return $danhgiacnList;

        }
        //lấy Đánh Giá Cá Nhân
        public static function laydgcn($conn, $id) {
            // Chuẩn bị câu truy vấn SQL để lấy thông tin Đánh Giá Cá Nhân
        $sql = "SELECT * FROM danhgiacn WHERE MaDGCN = $id";
    
        // Thực hiện câu truy vấn và lấy kết quả
        $result = mysqli_query($conn, $sql);
        // Tạo đối tượng thongtincanhan và khoa từ kết quả của câu truy vấn
        $danhgiacn_obj = new DanhgiaCN();
        $row = mysqli_fetch_assoc($result);
        $danhgiacn_obj->MaDGCN = $row["MaDGCN"];
        $danhgiacn_obj->MaCN = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
        $danhgiacn_obj->MaKhoa = Khoa::layKhoa($conn,$row["MaKhoa"]);
        $danhgiacn_obj->Manam = Nam::laynam($conn,$row["Manam"]);
        $danhgiacn_obj->SoQD = $row["SoQD"];
        $danhgiacn_obj->DanhGia = $row["DanhGia"];
        $danhgiacn_obj->Ngay = $row["Ngay"];
        $danhgiacn_obj->DonVi = $row["DonVi"];
        // Trả về đối tượng Đánh Giá Tập Thể
        return $danhgiacn_obj;
        }


        //Thêm Đánh Giá Cá nhân
        public function Themdanhgiacn($conn, $baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi thêm đánh giá";
        
            // tạo câu truy vấn để thêm đối tượng đánh giá cá nhân mới vào cơ sở dữ liệu
            $sql = "INSERT INTO danhgiacn (MaCN, MaKhoa, Manam, SoQD, DanhGia, Ngay, DonVi) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
        
            // Kiểm tra nếu MaCN là một mảng (nhiều lựa chọn)
            if (is_array($this->MaCN)) {
                $successCount = 0;
                foreach ($this->MaCN as $cn) {
                    $stmt->bind_param("ssissss", $cn, $this->MaKhoa, $this->Manam, $this->SoQD, $this->DanhGia, $this->Ngay, $this->DonVi);
                    if ($stmt->execute()) {
                        if ($stmt->affected_rows > 0) {
                            $successCount++;
                        }
                    }
                }
                if ($successCount > 0) {
                    $message = "Đánh Giá thành công cho $successCount cá nhân";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã cá nhân không tồn tại";
                }
            } else {
                $stmt->bind_param("ssiss", $this->MaCN, $this->MaKhoa, $this->Manam, $this->SoQD, $this->DanhGia , $this->Ngay, $this->DonVi);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $message = "Đánh Giá $this->MaCN thành công";
                    } else {
                        $message = "Không có thay đổi nào được thực hiện hoặc mã cá nhân không tồn tại";
                    }
                } else {
                    $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
                }
            }
        
            // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=danhgiaCN&message=" . urlencode($message));
            exit();
        }
        
        //Cập Nhật Đánh Giá Tập Cá Nhân
        public function Suadgcn($conn,$baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Sửa thể loại";
            // Chuẩn bị câu truy vấn SQL để cập nhật thông tin 
            $sql = "UPDATE danhgiacn SET SoQD = '$this->SoQD', DanhGia = '$this->DanhGia', Ngay = '$this->Ngay', DonVi = '$this->DonVi' WHERE MaDGCN = $this->MaDGCN";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Cập Đánh Giá $this->MaCN thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=danhgiaCN&message=" . urlencode($message));
            exit();
        }

        //Phân Trang Đánh Giá
        public static function layTongSoDanhGia($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
            $result = $conn->query($sql);

            $danhgiacnList = array();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Đánh Giá Cá Nhân vào danh sách
                    // Tạo đối tượng Khoa và đưa vào mảng
                    $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
                    $nam_obj = Nam::laynam($conn,$row["Manam"]);
                    $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                    $danhgiacn_obj = new DanhgiaCN();
                    $danhgiacn_obj->MaDGCN = $row["MaDGCN"];
                    $danhgiacn_obj->MaCN = $thongtincanhan_obj->HoTen;
                    $danhgiacn_obj->MaKhoa = $khoa_obj->TenKhoa;
                    $danhgiacn_obj->Manam = $nam_obj->Nam;
                    $danhgiacn_obj->SoQD = $row["SoQD"];
                    $danhgiacn_obj->DanhGia = $row["DanhGia"];
                    $danhgiacn_obj->Ngay = $row["Ngay"];
                    $danhgiacn_obj->DonVi = $row["DonVi"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

    }


?>