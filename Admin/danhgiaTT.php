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
    public $Ngay;
    public $DonVi;
    public $DeXuatDanhGia;
    public $FilePDF;

    


    // Lấy danh sách Đánh Giá Tập Thể
    public static function layDanhSach($conn) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá') ORDER by Manam ASC";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];


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
        $danhgiatt_obj->Manam = $row["Manam"];
        $danhgiatt_obj->DanhGia = $row["DanhGia"];
        $danhgiatt_obj->Ngay = $row["Ngay"];
        $danhgiatt_obj->DonVi = $row["DonVi"];
        $danhgiatt_obj->FilePDF = $row["FilePDF"];
        return $danhgiatt_obj;
    }



    //Thêm Đánh Giá Tập Thể
    public function Themdanhgiatt($conn, $baseUrl) {
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
    
                // Di chuyển file từ thư mục tạm sang vị trí lưu trữ
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, Manam, DanhGia, Ngay, DonVi, FilePDF) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
    
                    // Kiểm tra nếu MaKhoa là một mảng (nhiều lựa chọn)
                    if (is_array($this->MaKhoa)) {
                        $successCount = 0;
                        foreach ($this->MaKhoa as $khoa) {
                            $stmt->bind_param("sssssss", $khoa, $this->SoQD, $this->Manam, $this->DanhGia, $this->Ngay, $this->DonVi, $dest_path);
                            if ($stmt->execute()) {
                                if ($stmt->affected_rows > 0) {
                                    $successCount++;
                                }
                            }
                        }
                        if ($successCount > 0) {
                            $message = "Đánh Giá thành công cho $successCount Tập Thể và đã lưu file PDF";
                        } else {
                            $message = "Không có thay đổi nào được thực hiện hoặc mã cá nhân không tồn tại";
                        }
                    } else {
                        $stmt->bind_param("sssssss", $this->MaKhoa, $this->SoQD, $this->Manam, $this->DanhGia, $this->Ngay, $this->DonVi, $dest_path);
                        if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                $message = "Đánh Giá $this->MaKhoa thành công và đã lưu file PDF";
                            } else {
                                $message = "Không có thay đổi nào được thực hiện hoặc mã Tập Thể không tồn tại";
                            }
                        } else {
                            $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
                        }
                    }
    
                    // Chuyển hướng sau khi thực hiện xong
                    switch ($this->DanhGia) {
                        case "Tập Thể Lao Động Tiên Tiến":
                            header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
                            break;
                        case "Tập Thể Lao Động Xuất Sắc":
                            header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                            break;
                        case "Giấy Khen Hiệu Trưởng":
                            header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
                            break;
                        case "Bằng Khen Ủy Ban Nhân Dân Thành Phố":
                            header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
                            break;
                        case "Bằng Khen Thủ Tướng Chính Phủ":
                            header("Location: $baseUrl?p=danhgiaTTttcpview&message=" . urlencode($message));
                            break;
                        case "Huân Chương Lao Động Hạng Ba":
                            header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
                            break;
                        case "Huân Chương Lao Động Hạng Nhì":
                            header("Location: $baseUrl?p=danhgiaTThcldhnview&message=" . urlencode($message));
                            break;
                        default:
                            header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
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
    
        // Trả về thông báo kết quả
        return $message;
    }
    


    // Sửa Đánh Giá
    public function Suadgtt($conn, $baseUrl) {
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
        $stmt = $conn->prepare("UPDATE danhgiatt SET SoQD = ?, Manam = ?, DanhGia = ?, Ngay = ?, DonVi = ?, FilePDF = ? WHERE MaDGTT = ?");
        $stmt->bind_param("sisssss", $this->SoQD, $this->Manam, $this->DanhGia, $this->Ngay, $this->DonVi, $this->FilePDF, $this->MaDGTT);
    
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
            case "Tập Thể Lao Động Tiên Tiến":
                header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
                break;
            case "Tập Thể Lao Động Xuất Sắc":
                header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                break;
            case "Giấy Khen Hiệu Trưởng":
                header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
                break;
            case "Bằng Khen Ủy Ban Nhân Dân Thành Phố":
                header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
                break;
            case "Bằng Khen Thủ Tướng Chính Phủ":
                header("Location: $baseUrl?p=danhgiaTTttcpview&message=" . urlencode($message));
                break;
            case "Huân Chương Lao Động Hạng Ba":
                header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
                break;
            case "Huân Chương Lao Động Hạng Nhì":
                header("Location: $baseUrl?p=danhgiaTThcldhnview&message=" . urlencode($message));
                break;
            default:
                header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
        }
        exit();
    }
    

    // Hàm lấy FilePDF hiện tại
    private function getCurrentPDF($conn) {
        $FilePDF = null; 
    
        $stmt = $conn->prepare("SELECT FilePDF FROM danhgiatt WHERE MaDGTT = ?");
        $stmt->bind_param("s", $this->MaDGTT);
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
    


    // Xóa Đánh Giá
    public function XoaDanhGia($conn, $baseUrl) {
        $message = "Lỗi khi Xóa thể loại";
        $sql = "DELETE FROM danhgiatt WHERE MaDGTT = $this->MaDGTT";

        if (mysqli_query($conn, $sql)) {
            $message = "Xóa Đánh Giá thành công";
        }

        switch ($this->DanhGia) {
            case "Tập Thể Lao Động Tiên Tiến":
                header("Location: $baseUrl?p=danhgiaTTtientienview&message=" . urlencode($message));
                break;
            case "Tập Thể Lao Động Xuất Sắc":
                header("Location: $baseUrl?p=danhgiaTTxs&message=" . urlencode($message));
                break;
            case "Giấy Khen Hiệu Trưởng":
                header("Location: $baseUrl?p=danhgiaTThieutruong&message=" . urlencode($message));
                break;
            case "Bằng Khen Ủy Ban Nhân Dân Thành Phố":
                header("Location: $baseUrl?p=danhgiaTThubndtp&message=" . urlencode($message));
                break;
            case "Bằng Khen Thủ Tướng Chính Phủ":
                header("Location: $baseUrl?p=danhgiaTTttcpview&message=" . urlencode($message));
                break;
            case "Huân Chương Lao Động Hạng Ba":
                header("Location: $baseUrl?p=danhgiaTThcldhbview&message=" . urlencode($message));
                break;
            case "Huân Chương Lao Động Hạng Nhì":
                header("Location: $baseUrl?p=danhgiaTThcldhnview&message=" . urlencode($message));
                break;
            default:
                header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
        }
        exit();
    }


    //Phân Trang Đánh Giá
    public static function layTongSoDanhGia($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất Sắc ', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }


    //Phân trang Lao Động Tiên Tiến
    public static function layTongSoDanhGiaTT($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Tập Thể Lao Động Tiên Tiến')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaTTPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Tập Thể Lao Động Tiên Tiến') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }



    //Phân Trang Lao Đông Xuất Sắc 
    public static function layTongSoDanhGiaxs($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Tập Thể Lao Động Xuất Sắc')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaxsPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Tập Thể Lao Động Xuất Sắc') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }


    // Phân Trang Giấy Khen Hiệu Trưởng
    public static function layTongSoDanhGiaht($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Giấy Khen Hiệu Trưởng')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiahtPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Giấy Khen Hiệu Trưởng') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }

    // Phân Trang UBNDTP
    public static function layTongSoDanhGiaubndtp($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Bằng Khen Ủy Ban Nhân Dân Thành Phố')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaubndtpPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Bằng Khen Ủy Ban Nhân Dân Thành Phố') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }
    


    // Phân Trang Thủ Tướng Chính Phủ
    public static function layTongSoDanhGiattcp($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Bằng Khen Thủ Tướng Chính Phủ')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiattcp($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Bằng Khen Thủ Tướng Chính Phủ') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }


    // Phân Trang Huân Chương Lao Động Hạng Ba
    public static function layTongSoDanhGiahangba($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Huân Chương Lao Động Hạng Ba')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiahangba($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Huân Chương Lao Động Hạng Ba') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


                $danhgiattList[] = $danhgiatt_obj;
            }
        }
        return $danhgiattList;
    }


    // Phân Trang Huân Chương Lao Động Hạng Nhì
    public static function layTongSoDanhGiahangnhi($conn) {
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Huân Chương Lao Động Hạng Nhì')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiahangnhi($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM danhgiatt WHERE DanhGia IN ('Huân Chương Lao Động Hạng Nhì') ORDER BY Manam ASC LIMIT $startFrom, $recordsPerPage";
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
                $danhgiatt_obj->Ngay = $row["Ngay"];
                $danhgiatt_obj->DonVi = $row["DonVi"];
                $danhgiatt_obj->FilePDF = $row["FilePDF"];


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


    public static function laytongdexuatdanhgia($conn) {
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
                END AS DeXuatKhenThuong
            FROM danhgiatt dg
            JOIN khoa k ON dg.MaKhoa = k.MaKhoa
            JOIN nam n ON dg.Manam = n.Manam
            WHERE 
                dg.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Hoàn Thành Nhiệm Vụ', 'Tập Thể Lao Động Tiên Tiến', 'Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng','Bằng Khen Ủy Ban Nhân Dân Thành Phố','Bằng Khen Thủ Tướng Chính Phủ')
                AND NOT EXISTS (
                    SELECT 1 
                    FROM khethuongkyluat kt 
                    JOIN thongtincanhan tc ON kt.MaCN = tc.MaCN
                    WHERE 
                        tc.MaKhoa = k.MaKhoa 
                        AND kt.KyLuat IS NOT NULL 
                        AND kt.Manam = dg.Manam
                )
        )
        
        SELECT COUNT(*) AS tong_de_xuat FROM danh_sach WHERE DeXuatKhenThuong IS NOT NULL;";
        
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['tong_de_xuat'];
    }
    

    public static function laydexuatdanhgia($conn, $startFrom, $recordsPerPage) {
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
                END AS DeXuatKhenThuong
            FROM danhgiatt dg
            JOIN khoa k ON dg.MaKhoa = k.MaKhoa
            JOIN nam n ON dg.Manam = n.Manam
            WHERE 
                dg.DanhGia IN ('Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Xuất Sắc', 'Hoàn Thành Nhiệm Vụ', 'Tập Thể Lao Động Tiên Tiến', 'Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng','Bằng Khen Ủy Ban Nhân Dân Thành Phố','Bằng Khen Thủ Tướng Chính Phủ','Huân Chương Lao Động Hạng Ba', 'Huân Chương Lao Động Hạng Nhì')
                AND NOT EXISTS (
                    SELECT 1 
                    FROM khethuongkyluat kt 
                    JOIN thongtincanhan tc ON kt.MaCN = tc.MaCN
                    WHERE 
                        tc.MaKhoa = k.MaKhoa 
                        AND kt.KyLuat IS NOT NULL 
                        AND kt.Manam = dg.Manam
                )
        ),
        danh_sach_duoc_khen_thuong AS (
            SELECT DISTINCT k.TenKhoa, dg.Manam
            FROM danhgiatt dg
            JOIN khoa k ON dg.MaKhoa = k.MaKhoa
            WHERE dg.DanhGia IN (
                'Tập Thể Lao Động Tiên Tiến', 
                'Tập Thể Lao Động Xuất Sắc', 
                'Giấy Khen Hiệu Trưởng',
                'Bằng Khen Ủy Ban Nhân Dân Thành Phố', 
                'Bằng Khen Thủ Tướng Chính Phủ', 
                'Huân Chương Lao Động Hạng Ba', 
                'Huân Chương Lao Động Hạng Nhì'
            )
        )
        SELECT 
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
        GROUP BY ds.TenKhoa, ds.Nam, ds.DanhGia, ds.DeXuatKhenThuong
        ORDER BY ds.Nam DESC
        LIMIT $startFrom, $recordsPerPage";
    
        $result = $conn->query($sql);
    
        $danhgiattList = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $danhgiatt_obj = new DanhgiaTT();
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