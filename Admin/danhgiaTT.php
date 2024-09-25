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

    // Lấy danh sách đánh giá theo loại
    private static function layDanhSachDanhGiaTheoLoai($conn, $id) {
        $sql = "SELECT * FROM `danhgiatt` WHERE DanhGia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
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
                    $danhgiatt_obj->Ngay = $row["Ngay"];
                    $danhgiatt_obj->DonVi = $row["DonVi"];
                    $danhgiattList[] = $danhgiatt_obj;
                }
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
        $danhgiatt_obj->Manam = Nam::laynam($conn, $row["Manam"]);
        $danhgiatt_obj->DanhGia = $row["DanhGia"];
        $danhgiatt_obj->Ngay = $row["Ngay"];
        $danhgiatt_obj->DonVi = $row["DonVi"];
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
    



    // Cập Nhật Đánh Giá Tập Thể
    public function Suadgtt($conn, $baseUrl) {
        $message = "Lỗi khi Sửa thể loại";
        // tạo câu truy vấn 
        $stmt = $conn->prepare("UPDATE danhgiatt SET SoQD = ?, Manam = ?, DanhGia = ?, Ngay = ?, DonVi = ? WHERE MaDGTT = ?");
        $stmt->bind_param("sissss", $this->SoQD,$this->Manam,$this->DanhGia, $this->Ngay, $this->DonVi,$this->MaDGTT);
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
        $sql = "SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('TT_LAO_DONG_XS')";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function laydexuatdanhgia($conn) {
        $sql = "WITH danh_sach AS (
            SELECT 
                k.TenKhoa,
                n.Nam,
                dg.DanhGia,
                CASE 
                    WHEN dg.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ')
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia IN ('Tập Thể Lao Động Tiên Tiến', 'Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng')
                         ) THEN 'Tập Thể Lao Động Tiên Tiến'
        
                    WHEN dg.DanhGia = 'Tập Thể Lao Động Tiên Tiến'
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia = 'Tập Thể Lao Động Xuất Sắc'
                         ) THEN 'Tập Thể Lao Động Xuất Sắc'
        
                    WHEN dg.DanhGia = 'Tập Thể Lao Động Tiên Tiến'
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia = 'Giấy Khen Hiệu Trưởng'
                         ) THEN 'Giấy Khen Hiệu Trưởng'
        
                    WHEN dg.DanhGia IN ('Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng')
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                         ) THEN 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
        
                    WHEN dg.DanhGia = 'Bằng Khen Ủy Ban Nhân Dân Thành Phố'
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                         ) THEN 'Bằng Khen Thủ Tướng Chính Phủ'
        
                    WHEN dg.DanhGia = 'Bằng Khen Thủ Tướng Chính Phủ'
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                            AND dg2.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                         ) THEN 'Huân Chương Lao Động Hạng Ba'
        
                    WHEN dg.DanhGia = 'Huân Chương Lao Động Hạng Ba'
                         AND NOT EXISTS (
                             SELECT 1 FROM danhgiatt dg2 
                             WHERE dg.MaKhoa = dg2.MaKhoa 
                             AND dg.Manam = dg2.Manam 
                             AND dg2.DanhGia = 'Huân Chương Lao Động Hạng Nhì'
                         ) THEN 'Huân Chương Lao Động Hạng Nhì'
        
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
        WHERE DeXuatKhenThuong IS NOT NULL
        ORDER BY Nam, TenKhoa;
        ";
        $result = $conn->query($sql);

        $danhgiattList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
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