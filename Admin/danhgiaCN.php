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
        public $DeXuatDanhGia;
        public $FilePDF;


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
        $danhgiacn_obj->FilePDF = $row["FilePDF"];
        // Trả về đối tượng Đánh Giá Tập Thể
        return $danhgiacn_obj;
        }


        //Thêm Đánh Giá Cá nhân
        public function Themdanhgiacn($conn, $baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi thêm đánh giá";
            // Kiểm tra file PDF
            if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $fileType = $_FILES['file']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
        
                // Kiểm tra định dạng file
                $allowedfileExtensions = array('pdf');
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    // Đặt đường dẫn file lưu vào hệ thống 
                    $uploadFileDir = './uploads/';
                    $newFileName = time() . '_' . $fileName;
                    $dest_path = $uploadFileDir . $newFileName;
            

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // tạo câu truy vấn để thêm đối tượng đánh giá cá nhân mới vào cơ sở dữ liệu
                $sql = "INSERT INTO danhgiacn (MaCN, MaKhoa, Manam, SoQD, DanhGia, Ngay, DonVi,FilePDF) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
                $stmt = $conn->prepare($sql);
            
                // Kiểm tra nếu MaCN là một mảng (nhiều lựa chọn)
                if (is_array($this->MaCN)) {
                    $successCount = 0;
                    foreach ($this->MaCN as $cn) {
                        $stmt->bind_param("ssssssss", $cn, $this->MaKhoa, $this->Manam, $this->SoQD, $this->DanhGia, $this->Ngay, $this->DonVi, $dest_path);
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
                    $stmt->bind_param("ssiss", $this->MaCN, $this->MaKhoa, $this->Manam, $this->SoQD, $this->DanhGia , $this->Ngay, $this->DonVi, $dest_path);
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

                // Chuyển hướng sau khi thực hiện xong
                switch ($this->DanhGia) {
                    case "Lao Động Tiên Tiến":
                        header("Location: $baseUrl?p=khenthuongtt&message=" . urlencode($message));
                        break;
                    case "Giấy Khen Hiệu Trưởng":
                        header("Location: $baseUrl?p=khenthuonghieutruong&message=" . urlencode($message));
                        break;
                    case "Chiến Sĩ Thi Đua Cơ Sở":
                        header("Location: $baseUrl?p=khenthuongcstdcs&message=" . urlencode($message));
                        break;
                    case "Chiến Sĩ Thi Đua Thành Phố":
                        header("Location: $baseUrl?p=khenthuongcstdtp&message=" . urlencode($message));
                        break;
                    case "Chiến Sĩ Thi Đua Toàn Quốc":
                        header("Location: $baseUrl?p=khenthuongcstdtq&message=" . urlencode($message));
                        break;
                    case "Bằng Khen Ủy Ban Nhân Thành Phố":
                        header("Location: $baseUrl?p=khenthuongubnd&message=" . urlencode($message));
                        break;
                    case "Bằng Khen Thủ Tướng Chính Phủ":
                        header("Location: $baseUrl?p=khenthuongbkttcp&message=" . urlencode($message));
                        break;
                    case "Huân Chương Lao Động Hạng Ba":
                        header("Location: $baseUrl?p=khenthuonghb&message=" . urlencode($message));
                        break;
                    case "Huân Chương Lao Động Hạng Nhì":
                        header("Location: $baseUrl?p=khenthuonghn&message=" . urlencode($message));
                        break;
                    default:
                        header("Location: $baseUrl?p=danhgiaCN&message=" . urlencode($message));
                }

            } else {
                    $message = "Lỗi khi di chuyển file PDF vào thư mục lưu trữ.";
                }
            } else {
                $message = "Chỉ chấp nhận file PDF.";
            }
        } else {
            $message = "Vui lòng chọn file PDF để tải lên.";
        }
        return $message;
        }
        
        //Cập Nhật Đánh Giá Tập Cá Nhân
        public function Suadgcn($conn,$baseUrl) {
            $message = "Lỗi khi sửa đánh giá tập thể";
    
            // Kiểm tra nếu có tải lên file PDF mới
            if (isset($_FILES['FilePDF']) && $_FILES['FilePDF']['error'] == 0) {
                // Thư mục lưu file PDF
                $uploadDir = './uploads/';
                // Kiểm tra nếu thư mục không tồn tại, thì tạo mới
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = basename($_FILES['FilePDF']['name']);
                $targetFile = $uploadDir . $fileName;
        
                // Kiểm tra loại file và kích thước trước khi upload
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if ($fileType != "pdf") {
                    $message = "Chỉ chấp nhận file PDF";
                } elseif ($_FILES['FilePDF']['size'] > 5000000) { // Giới hạn kích thước 5MB
                    $message = "File PDF quá lớn. Giới hạn là 5MB.";
                } elseif (move_uploaded_file($_FILES['FilePDF']['tmp_name'], $targetFile)) {
                    // Lưu đường dẫn file PDF vào đối tượng
                    $this->FilePDF = $targetFile;
                } else {
                    $message = "Lỗi khi tải file PDF";
                }
            } else {
                // Nếu không có file mới, giữ nguyên giá trị cũ của file PDF
                $this->FilePDF = $this->getCurrentPDF($conn);
            }
        
            // Tạo câu truy vấn SQL
            $stmt = $conn->prepare("UPDATE danhgiacn SET SoQD = ?, Manam = ?, DanhGia = ?, Ngay = ?, DonVi = ?, FilePDF = ? WHERE MaDGCN = ?");
            $stmt->bind_param("sisssss", $this->SoQD, $this->Manam, $this->DanhGia, $this->Ngay, $this->DonVi, $this->FilePDF, $this->MaDGCN);
        
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "Sửa Đánh Giá $this->MaCN thành công";
                } else {
                    $message = "Không có thay đổi nào được thực hiện hoặc mã đánh giá không tồn tại";
                }
            } else {
                $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
            }
        
            $stmt->close();
        
            switch ($this->DanhGia) {
                case "Lao Động Tiên Tiến":
                    header("Location: $baseUrl?p=khenthuongtt&message=" . urlencode($message));
                    break;
                case "Giấy Khen Hiệu Trưởng":
                    header("Location: $baseUrl?p=khenthuonghieutruong&message=" . urlencode($message));
                    break;
                case "Chiến Sĩ Thi Đua Cơ Sở":
                    header("Location: $baseUrl?p=khenthuongcstdcs&message=" . urlencode($message));
                    break;
                case "Chiến Sĩ Thi Đua Thành Phố":
                    header("Location: $baseUrl?p=khenthuongcstdtp&message=" . urlencode($message));
                    break;
                case "Chiến Sĩ Thi Đua Toàn Quốc":
                    header("Location: $baseUrl?p=khenthuongcstdtq&message=" . urlencode($message));
                    break;
                case "Bằng Khen Ủy Ban Nhân Thành Phố":
                    header("Location: $baseUrl?p=khenthuongubnd&message=" . urlencode($message));
                    break;
                case "Bằng Khen Thủ Tướng Chính Phủ":
                    header("Location: $baseUrl?p=khenthuongbkttcp&message=" . urlencode($message));
                    break;
                case "Huân Chương Lao Động Hạng Ba":
                    header("Location: $baseUrl?p=khenthuonghb&message=" . urlencode($message));
                    break;
                case "Huân Chương Lao Động Hạng Nhì":
                    header("Location: $baseUrl?p=khenthuonghn&message=" . urlencode($message));
                    break;
                default:
                    header("Location: $baseUrl?p=danhgiaCN&message=" . urlencode($message));
            }    
            exit();
        }


        // Hàm lấy FilePDF hiện tại
        private function getCurrentPDF($conn) {
            $FilePDF = null; 
        
            $stmt = $conn->prepare("SELECT FilePDF FROM danhgiacn WHERE MaDGCN = ?");
            $stmt->bind_param("s", $this->MaDGCN);
            $stmt->execute();
            $stmt->bind_result($FilePDF);
            $stmt->fetch();
            $stmt->close();

            if (empty($FilePDF)) {
                $FilePDF = "Không có file PDF";
            }
        
            $this->FilePDF = $FilePDF; 
        
            return $FilePDF;
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Lao Động Tiên Tiến
        public static function layTongSoDanhGiatt($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Lao Động Tiên Tiến')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaTTPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Lao Động Tiên Tiến') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Giấy Khen Hiệu Trưởng
        public static function layTongSoDanhGiahieutruong($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Giấy Khen Hiệu Trưởng')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhHTGiaPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Giấy Khen Hiệu Trưởng') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }


        //Phân Trang Đánh Giá Chiến Sĩ Thi Đua Cơ Sở
        public static function layTongSoDanhGiaCS($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Chiến Sĩ Thi Đua Cơ Sở')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaCSPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Chiến Sĩ Thi Đua Cơ Sở') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Chiến Sĩ Thi Đua Thành Phố
        public static function layTongSoDanhGiaTP($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Chiến Sĩ Thi Đua Thành Phố')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaTPPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Chiến Sĩ Thi Đua Thành Phố') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }


        //Phân Trang Đánh Giá Chiến Sĩ Thi Đua Toàn Quốc
        public static function layTongSoDanhGiaTQ($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Chiến Sĩ Thi Đua Toàn Quốc')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaTQPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Chiến Sĩ Thi Đua Toàn Quốc') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Bằng Khen Ủy Ban Nhân Thành Phố
        public static function layTongSoDanhGiaUBND($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Bằng Khen Ủy Ban Nhân Thành Phố')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaUBNDPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Bằng Khen Ủy Ban Nhân Thành Phố') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Bằng Khen Thủ Tướng Chính Phủ
        public static function layTongSoDanhGiaTTCP($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Bằng Khen Thủ Tướng Chính Phủ')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaTTCPPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Bằng Khen Thủ Tướng Chính Phủ') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Huân Chưởng Lao Động Hạng Ba
        public static function layTongSoDanhGiaHB($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Huân Chưởng Lao Động Hạng Ba')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaHBPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Huân Chưởng Lao Động Hạng Ba') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        //Phân Trang Đánh Giá Huân Chưởng Lao Động Hạng Nhì
        public static function layTongSoDanhGiaHN($conn) {
            $sql = "SELECT COUNT(*) FROM danhgiacn WHERE DanhGia IN ('Huân Chưởng Lao Động Hạng Nhì')";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }

        public static function layDanhGiaHNPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM danhgiacn WHERE DanhGia IN ('Huân Chưởng Lao Động Hạng Nhì') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                    $danhgiacn_obj->FilePDF = $row["FilePDF"];


                    $danhgiacnList[] = $danhgiacn_obj;
                }
                }
                return $danhgiacnList;
        }

        public static function laytongdexuatdanhgia($conn) {
            $sql = "WITH danh_sach AS (
    SELECT 
        tc.HoTen,
        k.TenKhoa,
        n.Nam,
        dg.DanhGia,
        CASE 
    	WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở')
    AND (
        SELECT COUNT(DISTINCT n.Manam) 
        FROM danhgiacn dg5 
        JOIN nam n ON dg5.Manam = n.Manam
        WHERE dg5.MaCN = dg.MaCN 
        AND dg5.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở')
        AND n.Manam <= dg.Manam
    )= 2
    AND (
        SELECT COUNT(*) 
        FROM sangkien sk 
        WHERE sk.MaCN = dg.MaCN  
        AND sk.CapSK IN ('Sáng Kiên Cấp Cơ Sở')
    )= 2
    AND NOT EXISTS (
           SELECT 1 
           FROM danhgiacn dg3 
           WHERE dg3.MaCN = dg.MaCN  
             AND dg3.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
       )
THEN 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
    
    	WHEN (dg.DanhGia = 'Lao Động Tiên Tiến')
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

WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ')
       AND NOT EXISTS (
           SELECT 1 
           FROM danhgiacn dg2 
           WHERE dg2.MaCN = dg.MaCN  
             AND dg2.DanhGia = 'Lao Động Tiên Tiến'
       )
    THEN 'Lao Động Tiên Tiến'

WHEN dg.DanhGia IN ('Lao Động Tiên Tiến')
       AND NOT EXISTS (
           SELECT 1 
           FROM danhgiacn dg2 
           WHERE dg2.MaCN = dg.MaCN  
             AND dg2.DanhGia = 'Giấy Khen Hiệu Trưởng'
       )
    THEN 'Giấy Khen Hiệu Trưởng'
    
    WHEN dg.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                AND (
                    SELECT COUNT(DISTINCT n.Manam) 
                    FROM danhgiacn dg4 
                    JOIN nam n ON dg4.Manam = n.Manam
                    WHERE dg4.MaCN = dg.MaCN 
                    AND dg4.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                    AND n.Manam <= dg.Manam
                )= 3
                AND EXISTS (
                    SELECT 1 
                    FROM sangkien sk 
                    WHERE sk.MaCN = dg.MaCN  
                    AND sk.CapSK IN ('Sáng Kiên Cấp Thành Phố', 'Khoa Học Công Nghệ')
                )
    			 AND NOT EXISTS (
                       SELECT 1 
                       FROM danhgiacn dg2 
                       WHERE dg2.MaCN = dg.MaCN  
                         AND dg2.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                   )
            THEN 'Chiến Sĩ Thi Đua Thành Phố'
    
    WHEN dg.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                AND (
                    SELECT COUNT(DISTINCT n.Manam) 
                    FROM danhgiacn dg5 
                    JOIN nam n ON dg5.Manam = n.Manam
                    WHERE dg5.MaCN = dg.MaCN 
                    AND dg5.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                    AND n.Manam <= dg.Manam
                ) = 2
                AND EXISTS (
                    SELECT 1 
                    FROM sangkien sk 
                    WHERE sk.MaCN = dg.MaCN  
                    AND sk.CapSK IN ('Sáng Kiên Cấp Thành Phố', 'Khoa Học Công Nghệ')
                )AND NOT EXISTS (
                       SELECT 1 
                       FROM danhgiacn dg2 
                       WHERE dg2.MaCN = dg.MaCN  
                         AND dg2.DanhGia = 'Chiến Sĩ Thi Đua Toàn Quốc'
                   )
            THEN 'Chiến Sĩ Thi Đua Toàn Quốc'
    
    	WHEN 
            -- Kiểm tra có 5 năm liên tục hoàn thành tốt nhiệm vụ trở lên
            (
                SELECT COUNT(DISTINCT n5.Manam) 
                FROM danhgiacn dg5 
                JOIN nam n5 ON dg5.Manam = n5.Manam
                WHERE dg5.MaCN = dg.MaCN 
                AND dg5.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc')
                AND n5.Manam <= dg.Manam
            )= 5
            AND (
                SELECT COUNT(*) 
                FROM danhgiacn dg6
                WHERE dg6.MaCN = dg.MaCN
                AND dg6.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
            )= 3
            AND NOT EXISTS (
                SELECT 1 
                FROM danhgiacn dg7
                WHERE dg7.MaCN = dg.MaCN  
                AND dg7.DanhGia IN ('Bằng Khen Thủ Tướng Chính Phủ')
            )
        THEN 'Bằng Khen Thủ Tướng Chính Phủ'
    
    	WHEN dg.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
            -- Kiểm tra đã nhận 'Bằng Khen Thủ Tướng Chính Phủ'
            AND EXISTS (
                SELECT 1 
                FROM danhgiacn dg1 
                WHERE dg1.MaCN = dg.MaCN
                AND dg1.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
            )
            AND (
                SELECT COUNT(DISTINCT n2.Manam) 
                FROM danhgiacn dg2 
                JOIN nam n2 ON dg2.Manam = n2.Manam
                WHERE dg2.MaCN = dg.MaCN
                AND dg2.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở')
                AND n2.Manam >= (
                    SELECT MIN(n1.Manam)
                    FROM danhgiacn dg1
                    JOIN nam n1 ON dg1.Manam = n1.Manam
                    WHERE dg1.MaCN = dg.MaCN
                    AND dg1.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                )
            )>= 5
            AND EXISTS (
                SELECT 1 
                FROM danhgiacn dg3
                JOIN nam n3 ON dg3.Manam = n3.Manam
                WHERE dg3.MaCN = dg.MaCN
                AND dg3.DanhGia = 'Hoàn Thành Xuất Sắc'
                AND n3.Manam >= (
                    SELECT MIN(n1.Manam)
                    FROM danhgiacn dg1
                    JOIN nam n1 ON dg1.Manam = n1.Manam
                    WHERE dg1.MaCN = dg.MaCN
                    AND dg1.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                )
            )
            AND (
                SELECT COUNT(*) 
                FROM danhgiacn dg4
                WHERE dg4.MaCN = dg.MaCN
                AND dg4.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
            )= 3
            AND NOT EXISTS (
                SELECT 1 
                FROM danhgiacn dg5
                WHERE dg5.MaCN = dg.MaCN  
                AND dg5.DanhGia IN ('Huân Chương Lao Động Hạng Ba')
            )
        THEN 'Huân Chương Lao Động Hạng Ba'
	
    WHEN dg.DanhGia = 'Huân Chương Lao Động Hạng Ba'
            -- Kiểm tra đã nhận 'Huân Chương Lao Động Hạng Ba'
           AND EXISTS (
                SELECT 1 
                FROM danhgiacn dg1 
                WHERE dg1.MaCN = dg.MaCN
                AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
            )
            
            -- Kiểm tra có 5 năm liên tục hoàn thành tốt nhiệm vụ trở lên sau khi nhận 'Huân Chương Lao Động Hạng Ba'
            AND (
                SELECT COUNT(DISTINCT n2.Manam) 
                FROM danhgiacn dg2 
                JOIN nam n2 ON dg2.Manam = n2.Manam
                WHERE dg2.MaCN = dg.MaCN
                AND dg2.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở', 'Chiến Sĩ Thi Đua Thành Phố')
                AND n2.Manam >= (
                    SELECT MIN(n1.Manam)
                    FROM danhgiacn dg1
                    JOIN nam n1 ON dg1.Manam = n1.Manam
                    WHERE dg1.MaCN = dg.MaCN
                    AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                )
            ) >= 5
            
            -- Kiểm tra có ít nhất 2 năm hoàn thành xuất sắc nhiệm vụ trong 5 năm đó
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
            AND NOT EXISTS (
                SELECT 1 
                FROM danhgiacn dg5
                WHERE dg5.MaCN = dg.MaCN  
                AND dg5.DanhGia IN ('Huân Chương Lao Động Hạng Nhì')
            )
        THEN 'Huân Chương Lao Động Hạng Nhì'
            ELSE NULL
        END AS DeXuatKhenThuong
    FROM danhgiacn dg
    JOIN khoa k ON dg.MaKhoa = k.MaKhoa
    JOIN nam n ON dg.Manam = n.Manam
    JOIN thongtincanhan tc ON dg.MaCN = tc.MaCN
    WHERE 
        dg.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Hoàn Thành Nhiệm Vụ', 'Lao Động Tiên Tiến', 'Chiến Sĩ Thi Đua Cơ Sở', 'Giấy Khen Hiệu Trưởng','Chiến Sĩ Thi Đua Thành Phố','Chiến Sĩ Thi Đua Toàn Quốc','Bằng Khen Ủy Ban Nhân Dân Thành Phố','Bằng Khen Thủ Tướng Chính Phủ','Huân Chương Lao Động Hạng Ba','Huân Chương Lao Động Hạng Nhì')
        AND NOT EXISTS (
            SELECT 1 
            FROM khethuongkyluatcn kt
            WHERE kt.MaCN = dg.MaCN
        )
)


SELECT COUNT(*) AS tong_de_xuat
FROM danhgiacn dg
JOIN khoa k ON dg.MaKhoa = k.MaKhoa
JOIN nam n ON dg.Manam = n.Manam
WHERE dg.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc')
AND NOT EXISTS (
    SELECT 1 
    FROM khethuongkyluatcn kt
    WHERE kt.MaCN = dg.MaCN
)";
            
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            return $row['tong_de_xuat'];
        }
    
        public static function laydexuatdanhgia($conn, $startFrom, $recordsPerPage) {
            $sql = "WITH danh_sach AS (
    SELECT 
        tc.HoTen,
        k.TenKhoa,
        n.Nam,
        dg.DanhGia,
        CASE 
    	WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ')
       AND NOT EXISTS (
           SELECT 1 
           FROM danhgiacn dg2 
           WHERE dg2.MaCN = dg.MaCN
           AND dg2.Manam = dg.Manam
             AND dg2.DanhGia = 'Lao Động Tiên Tiến'
       )
    THEN 'Lao Động Tiên Tiến'

WHEN dg.DanhGia IN ('Lao Động Tiên Tiến')
       AND NOT EXISTS (
           SELECT 1 
           FROM danhgiacn dg2 
           WHERE dg2.MaCN = dg.MaCN  
             AND dg2.DanhGia = 'Giấy Khen Hiệu Trưởng'
       )
    THEN 'Giấy Khen Hiệu Trưởng'
    
    WHEN dg.DanhGia IN ('Chiến Sĩ Thi Đua Toàn Quốc')
             AND (
                 -- Kiểm tra nếu có 2 năm liên tiếp đạt danh hiệu CSTĐCS
                 (SELECT COUNT(DISTINCT n.Manam)
                  FROM danhgiacn dg1 
                  JOIN nam n ON dg1.Manam = n.Manam
                  WHERE dg1.MaCN = dg.MaCN 
                  AND dg1.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                  AND n.Manam BETWEEN dg.Manam - 1 AND dg.Manam) >= 2
                 OR
                 -- Kiểm tra nếu có 2 năm liên tiếp hoàn thành xuất sắc nhiệm vụ
                 (SELECT COUNT(DISTINCT n.Manam)
                  FROM danhgiacn dg2
                  JOIN nam n ON dg2.Manam = n.Manam
                  WHERE dg2.MaCN = dg.MaCN 
                  AND dg2.DanhGia = 'Hoàn Thành Xuất Sắc'
                  AND n.Manam BETWEEN dg.Manam - 1 AND dg.Manam) >= 2
             
             AND 
                 -- Kiểm tra nếu có 2 sáng kiến cấp cơ sở
                 (SELECT COUNT(*)
                 FROM sangkien sk
                 WHERE sk.MaCN = dg.MaCN
                  AND sk.Manam = dg.Manam
                 AND sk.CapSK = 'Sáng Kiên Cấp Cơ Sở') >= 2
            )
             AND NOT EXISTS (
                 -- Đảm bảo không có đánh giá 'Bằng Khen Ủy Ban Nhân Dân Thành Phố' trong năm hiện tại
                 SELECT 1 
                 FROM danhgiacn dg3 
                 WHERE dg3.MaCN = dg.MaCN
                 AND dg3.Manam = dg.Manam
                 AND dg3.DanhGia = 'Bằng Khen Ủy Ban Nhân Thành Phố'
             )
        THEN 'Bằng Khen Ủy Ban Nhân Thành Phố'
    
    	WHEN (dg.DanhGia = 'Lao Động Tiên Tiến')
       AND EXISTS (
           SELECT 1 
           FROM danhgiacn dg2 
           WHERE dg2.MaCN = dg.MaCN
           AND dg2.Manam = dg.Manam
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
             AND sk.CapSK IN ('Cấp Sáng Kiên Cấp Cơ Sở', 'Nghiên Cứu Khoa Học')
       )
       AND NOT EXISTS (
           SELECT 1 
           FROM danhgiacn dg3 
           WHERE dg3.MaCN = dg.MaCN  
             AND dg3.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
       )
    THEN 'Chiến Sĩ Thi Đua Cơ Sở'


    
    WHEN dg.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                AND (
                    SELECT COUNT(DISTINCT n.Manam) 
                    FROM danhgiacn dg4 
                    JOIN nam n ON dg4.Manam = n.Manam
                    WHERE dg4.MaCN = dg.MaCN 
                    AND dg4.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
                    AND n.Manam <= dg.Manam
                )>= 3
                AND EXISTS (
                    SELECT 1 
                    FROM sangkien sk 
                    WHERE sk.MaCN = dg.MaCN  
                    AND sk.CapSK IN ('Sáng Kiên Cấp Thành Phố', 'Khoa Học Công Nghệ')
                )
    			 AND NOT EXISTS (
                       SELECT 1 
                       FROM danhgiacn dg2 
                       WHERE dg2.MaCN = dg.MaCN  
                         AND dg2.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                   )
            THEN 'Chiến Sĩ Thi Đua Thành Phố'
    
    WHEN dg.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                AND (
                    SELECT COUNT(DISTINCT n.Manam) 
                    FROM danhgiacn dg5 
                    JOIN nam n ON dg5.Manam = n.Manam
                    WHERE dg5.MaCN = dg.MaCN 
                    AND dg5.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
                    AND n.Manam <= dg.Manam
                ) = 2
                AND EXISTS (
                    SELECT 1 
                    FROM sangkien sk 
                    WHERE sk.MaCN = dg.MaCN  
                    AND sk.CapSK IN ('Sáng Kiên Cấp Thành Phố', 'Khoa Học Công Nghệ')
                )AND NOT EXISTS (
                       SELECT 1 
                       FROM danhgiacn dg2 
                       WHERE dg2.MaCN = dg.MaCN  
                         AND dg2.DanhGia = 'Chiến Sĩ Thi Đua Toàn Quốc'
                   )
            THEN 'Chiến Sĩ Thi Đua Toàn Quốc'

     WHEN dg.DanhGia = 'Bằng Khen Ủy Ban Nhân Thành Phố'
    AND (
        SELECT COUNT(DISTINCT n5.Manam)
        FROM danhgiacn dg5
        JOIN nam n5 ON dg5.Manam = n5.Manam
        WHERE dg5.MaCN = dg.MaCN
        AND dg5.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc')
        AND n5.Manam BETWEEN (dg.Manam - 4) AND dg.Manam  -- Kiểm tra 5 năm liên tục
    ) >= 5
    AND (
        SELECT COUNT(*)
        FROM danhgiacn dg6
        WHERE dg6.MaCN = dg.MaCN
        AND dg6.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
    ) >= 3
    AND NOT EXISTS (
        SELECT 1
        FROM danhgiacn dg7
        WHERE dg7.MaCN = dg.MaCN
        AND dg7.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
    )
THEN 'Bằng Khen Thủ Tướng Chính Phủ'

    
    	WHEN dg.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
            AND EXISTS (
                SELECT 1 
                FROM danhgiacn dg1 
                WHERE dg1.MaCN = dg.MaCN
                AND dg1.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
            )
            
            -- Kiểm tra có 5 năm liên tục hoàn thành tốt nhiệm vụ trở lên sau khi nhận 'Bằng Khen Thủ Tướng Chính Phủ'
            AND (
                SELECT COUNT(DISTINCT n2.Manam) 
                FROM danhgiacn dg2 
                JOIN nam n2 ON dg2.Manam = n2.Manam
                WHERE dg2.MaCN = dg.MaCN
                AND dg2.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở')
                AND n2.Manam >= (
                    SELECT MIN(n1.Manam)
                    FROM danhgiacn dg1
                    JOIN nam n1 ON dg1.Manam = n1.Manam
                    WHERE dg1.MaCN = dg.MaCN
                    AND dg1.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                )
            )>= 5
            AND EXISTS (
                SELECT 1 
                FROM danhgiacn dg3
                JOIN nam n3 ON dg3.Manam = n3.Manam
                WHERE dg3.MaCN = dg.MaCN
                AND dg3.DanhGia = 'Hoàn Thành Xuất Sắc'
                AND n3.Manam >= (
                    SELECT MIN(n1.Manam)
                    FROM danhgiacn dg1
                    JOIN nam n1 ON dg1.Manam = n1.Manam
                    WHERE dg1.MaCN = dg.MaCN
                    AND dg1.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                )
            )

            AND (
                SELECT COUNT(*) 
                FROM danhgiacn dg4
                WHERE dg4.MaCN = dg.MaCN
                AND dg4.DanhGia = 'Chiến Sĩ Thi Đua Cơ Sở'
            )>= 3
            AND NOT EXISTS (
                SELECT 1 
                FROM danhgiacn dg5
                WHERE dg5.MaCN = dg.MaCN  
                AND dg5.DanhGia IN ('Huân Chương Lao Động Hạng Ba')
            )
        THEN 'Huân Chương Lao Động Hạng Ba'
	
     WHEN dg.DanhGia = 'Huân Chương Lao Động Hạng Ba'
    -- Kiểm tra đã nhận 'Huân Chương Lao Động Hạng Ba'
    AND EXISTS (
        SELECT 1 
        FROM danhgiacn dg1 
        WHERE dg1.MaCN = dg.MaCN
        AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
    )

    -- Kiểm tra có 5 năm liên tục hoàn thành tốt nhiệm vụ trở lên sau khi nhận 'Huân Chương Lao Động Hạng Ba'
    AND (
        SELECT COUNT(DISTINCT n2.Manam) 
        FROM danhgiacn dg2 
        JOIN nam n2 ON dg2.Manam = n2.Manam
        WHERE dg2.MaCN = dg.MaCN
        AND dg2.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Chiến Sĩ Thi Đua Cơ Sở', 'Chiến Sĩ Thi Đua Thành Phố')
        AND n2.Manam >= (
            SELECT MIN(n1.Manam)
            FROM danhgiacn dg1
            JOIN nam n1 ON dg1.Manam = n1.Manam
            WHERE dg1.MaCN = dg.MaCN
            AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
        )
    ) >= 5

    -- Kiểm tra có ít nhất 2 năm hoàn thành xuất sắc nhiệm vụ trong 5 năm đó
    AND (
        SELECT COUNT(*)
        FROM danhgiacn dg3
        JOIN nam n3 ON dg3.Manam = n3.Manam
        WHERE dg3.MaCN = dg.MaCN
        AND dg3.DanhGia = 'Hoàn Thành Xuất Sắc'
        AND n3.Manam >= (
            SELECT MIN(n1.Manam)
            FROM danhgiacn dg1
            JOIN nam n1 ON dg1.Manam = n1.Manam
            WHERE dg1.MaCN = dg.MaCN
            AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
        )
    ) >= 2

    AND EXISTS (
        SELECT 1 
        FROM danhgiacn dg4
        WHERE dg4.MaCN = dg.MaCN
        AND dg4.DanhGia = 'Chiến Sĩ Thi Đua Thành Phố'
        AND dg4.Manam >= (
            SELECT MIN(n1.Manam)
            FROM danhgiacn dg1
            JOIN nam n1 ON dg1.Manam = n1.Manam
            WHERE dg1.MaCN = dg.MaCN
            AND dg1.DanhGia = 'Huân Chương Lao Động Hạng Ba'
        )
    )

    -- Kiểm tra chưa nhận 'Huân Chương Lao Động Hạng Nhì'
    AND NOT EXISTS (
        SELECT 1 
        FROM danhgiacn dg5
        WHERE dg5.MaCN = dg.MaCN  
        AND dg5.DanhGia = 'Huân Chương Lao Động Hạng Nhì'
    )
THEN 'Huân Chương Lao Động Hạng Nhì'
            ELSE NULL
        END AS DeXuatKhenThuong
    FROM danhgiacn dg
    JOIN khoa k ON dg.MaKhoa = k.MaKhoa
    JOIN nam n ON dg.Manam = n.Manam
    JOIN thongtincanhan tc ON dg.MaCN = tc.MaCN
    WHERE 
        dg.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Hoàn Thành Nhiệm Vụ', 'Lao Động Tiên Tiến', 'Chiến Sĩ Thi Đua Cơ Sở', 'Giấy Khen Hiệu Trưởng','Chiến Sĩ Thi Đua Thành Phố','Chiến Sĩ Thi Đua Toàn Quốc','Bằng Khen Ủy Ban Nhân Thành Phố','Bằng Khen Thủ Tướng Chính Phủ','Huân Chương Lao Động Hạng Ba','Huân Chương Lao Động Hạng Nhì')
        AND NOT EXISTS (
            SELECT 1 
            FROM khethuongkyluatcn kt
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
    JOIN thongtincanhan tc ON dg.MaCN = tc.MaCN
    WHERE dg.DanhGia IN ('Lao Động Tiên Tiến', 'Giấy Khen Hiệu Trưởng', 'Chiến Sĩ Thi Đua Cơ Sở', 'Chiến Sĩ Thi Đua Thành Phố', 'Chiến Sĩ Thi Đua Toàn Quốc', 'Bằng Khen Ủy Ban Nhân Thành Phố', 'Bằng Khen Thủ Tướng Chính Phủ', 'Huân Chương Lao Động Hạng Ba', 'Huân Chương Lao Động Hạng Nhì')
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
ORDER BY ds.Nam DESC
LIMIT $startFrom, $recordsPerPage;";
        
            $result = $conn->query($sql);
        
            $danhgiattList = array();
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $danhgiatt_obj = new DanhgiaCN();
                    $danhgiatt_obj->MaCN = $row["HoTen"];
                    $danhgiatt_obj->MaKhoa = $row["TenKhoa"];
                    $danhgiatt_obj->Manam = $row["Nam"];
                    $danhgiatt_obj->DanhGia = $row["DanhGia"];
                    $danhgiatt_obj->DeXuatDanhGia = $row["DeXuatKhenThuong"];
                    $danhgiattList[] = $danhgiatt_obj;
                }
            }
        
            return $danhgiattList;
        }
        
    }


    


?>