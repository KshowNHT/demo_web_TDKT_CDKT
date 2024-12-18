<?php
include('./Khoa.php');
include('./nam.php');

class ktkyluattt{
    public $MaKTKLtt;
    public $MaKhoa;
    public $KhenThuong;
    public $Manam;
    public $SoQuyetDinh;
    public $NgayQuyetDinh;
    public $DonVi;
    public $GhiChu;
    public $FilePDF;


    //Phân Trang khen thưởng kỷ luật
    public static function layTongSoktkyluat($conn) {
        $sql = "SELECT COUNT(*) FROM khethuongkyluattt";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function layDanhGiaPhanTrang($conn, $startFrom, $recordsPerPage) {
        $sql = "SELECT * FROM khethuongkyluattt ORDER BY Manam DESC LIMIT $startFrom, $recordsPerPage";
        $result = $conn->query($sql);

        $ktkyluatttList = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nam_obj = Nam::laynam($conn,$row["Manam"]);
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $ktkyluat_obj = new ktkyluattt();
                $ktkyluat_obj->MaKTKLtt = $row["MaKTKLtt"];
                $ktkyluat_obj->MaKhoa = $khoa_obj->TenKhoa;
                $ktkyluat_obj->KhenThuong = $row["KhenThuong"];
                $ktkyluat_obj->Manam = $nam_obj->Nam;
                $ktkyluat_obj->SoQuyetDinh = $row["SoQuyetDinh"];
                $ktkyluat_obj->NgayQuyetDinh = $row["NgayQuyetDinh"];
                $ktkyluat_obj->DonVi = $row["DonVi"];
                $ktkyluat_obj->GhiChu = $row["GhiChu"];
                $ktkyluat_obj->FilePDF = $row["FilePDF"];


                $ktkyluatttList[] = $ktkyluat_obj;
            }
        }
        return $ktkyluatttList;
    }


    // Lấy khen thưởng kỷ luật theo ID
    public static function laydgtt($conn, $id) {
        $sql = "SELECT * FROM khethuongkyluattt WHERE MaKTKLtt = $id";
        $result = mysqli_query($conn, $sql);

        $ktkyluat_obj = new ktkyluattt();
        $row = mysqli_fetch_assoc($result);
        $ktkyluat_obj->MaKTKLtt = $row["MaKTKLtt"];
        $ktkyluat_obj->MaKhoa = Khoa::layKhoa($conn,$row["MaKhoa"]);
        $ktkyluat_obj->KhenThuong = $row["KhenThuong"];
        $ktkyluat_obj->Manam = Nam::laynam($conn, $row["Manam"]);
        $ktkyluat_obj->SoQuyetDinh = $row["SoQuyetDinh"];
        $ktkyluat_obj->NgayQuyetDinh = $row["NgayQuyetDinh"];
        $ktkyluat_obj->DonVi = $row["DonVi"];
        $ktkyluat_obj->GhiChu = $row["GhiChu"];
        $ktkyluat_obj->FilePDF = $row["FilePDF"];
        return $ktkyluat_obj;
    }

    //Thêm khen thưởng kỷ luật
    public function Themktkyluattt($conn, $baseUrl) {
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
                    $sql = "INSERT INTO khethuongkyluattt (MaKhoa, KhenThuong, Manam, SoQuyetDinh, NgayQuyetDinh, DonVi , FilePDF, GhiChu) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
    
                    if (is_array($this->MaKhoa)) {
                        $successCount = 0;
                        foreach ($this->MaKhoa as $khoa) {
                            $stmt->bind_param("ssssssss", $khoa, $this->KhenThuong, $this->Manam, $this->SoQuyetDinh, $this->NgayQuyetDinh, $this->DonVi , $dest_path, $this->GhiChu);
                            if ($stmt->execute()) {
                                if ($stmt->affected_rows > 0) {
                                    $successCount++;
                                }
                            }
                        }
                        if ($successCount > 0) {
                            $message = "Xét Khen Thưởng Và Kỷ Luật thành công cho $successCount và đã lưu file PDF";
                        } else {
                            $message = "Không có thay đổi nào được thực hiện hoặc mã cá nhân không tồn tại";
                        }
                    } else {
                        $stmt->bind_param("ssssssss", $this->MaKhoa ,$this->KhenThuong, $this->Manam, $this->SoQuyetDinh, $this->NgayQuyetDinh, $this->DonVi ,$dest_path, $this->GhiChu);
                        if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                $message = "$this->MaKhoa thành công và đã lưu file PDF";
                            } else {
                                $message = "Không có thay đổi nào được thực hiện hoặc mã Tập Thể không tồn tại";
                            }
                        } else {
                            $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
                        }
                    }
    
                    // Chuyển hướng sau khi thực hiện xong
                    header("Location: $baseUrl?p=kttt&message=" . urlencode($message));
    
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

    // Sửa Khen Thưởng Kỷ Luật
    public function Suaktkl($conn, $baseUrl) {
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
        $stmt = $conn->prepare("UPDATE khethuongkyluattt SET KhenThuong = ?, Manam = ?, SoQuyetDinh = ?, NgayQuyetDinh = ?, DonVi = ?, FilePDF = ?, GhiChu = ? WHERE MaKTKLtt = ?");
        $stmt->bind_param("ssssssss", $this->KhenThuong,  $this->Manam, $this->SoQuyetDinh, $this->NgayQuyetDinh, $this->DonVi, $this->FilePDF, $this->GhiChu, $this->MaKTKLtt);

    
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $message = "Sửa Khen Thưởng Kỷ Luật $this->MaKhoa thành công";
            } else {
                $message = "Không có thay đổi nào được thực hiện hoặc mã Khen Thưởng Kỷ Luật không tồn tại";
            }
        } else {
            $message = "Lỗi khi thực hiện câu lệnh: " . $stmt->error;
        }
    
        $stmt->close();
    
        // Chuyển hướng sau khi thực hiện xong
        header("Location: $baseUrl?p=kttt&message=" . urlencode($message));
        exit();
    }

    // Hàm lấy FilePDF hiện tại
    private function getCurrentPDF($conn) {
        $FilePDF = null; 
    
        $stmt = $conn->prepare("SELECT FilePDF FROM khethuongkyluattt WHERE MaKTKLtt = ?");
        $stmt->bind_param("s", $this->MaKTKLtt);
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

    // Xóa Khen Thưởng Kỷ Luật
    public function Xoaktkl($conn, $baseUrl) {
        $message = "Lỗi khi Xóa thể loại";
        $sql = "DELETE FROM khethuongkyluattt WHERE MaKTKLtt = $this->MaKTKLtt";

        if (mysqli_query($conn, $sql)) {
            $message = "Xóa Đánh Giá thành công";
        }

        // Chuyển hướng sau khi thực hiện xong
        header("Location: $baseUrl?p=kttt&message=" . urlencode($message));
        exit();
    }
    
}
?>
