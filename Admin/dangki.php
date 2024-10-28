<?php
    class taikhoan{
        public $MaTk;
        public $TenTk;
        public $MatKhau;
        public $VaiTro;

    //đăng kí 
        public function ThemTK($conn,$baseUrl) {
                    
            // Thông báo cần gửi
            $message = "Lỗi khi thêm thể loại";
        
            // Mã hóa mật khẩu
            $hashedPassword = password_hash($this->MatKhau, PASSWORD_DEFAULT);
            // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
            $sql = "INSERT INTO  taikhoan (TenTk,MatKhau,VaiTro) VALUES ('$this->TenTk','$hashedPassword', '$this->VaiTro')";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Tạo Tài Khoản Thành Công";
            }else{
                $message = "Tạo Tài Khoản Không Thành Công";
            }
            // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=thongtincanhan&message=" . urlencode($message));
            exit();
        }


        //Lấy Danh Sách Tài Khoản
        public static function layDanhSach($conn) {
            $Dstaikhoan = array();
            $sql = "SELECT * FROM `taikhoan`";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $taikhoan_obj = new taikhoan();
                    $taikhoan_obj->MaTk = $row["MaTk"];
                    $taikhoan_obj->TenTk = $row["TenTk"];
                    $taikhoan_obj->VaiTro = $row["VaiTro"];
                    $taikhoan_obj->MatKhau = $row["MatKhau"];
                    $Dstaikhoan[] = $taikhoan_obj;
                }
            }
    
            return $Dstaikhoan;
        }



        // Lấy Thông Tin Tài Khoản
        public static function layTaikhoan($conn, $id) {
            $sql = "SELECT * FROM taikhoan WHERE MaTk = $id";
            $result = mysqli_query($conn, $sql);

            $taikhoan_obj = new taikhoan();
            if ($row = mysqli_fetch_assoc($result)) {
                $taikhoan_obj->MaTk = $row["MaTk"];
                $taikhoan_obj->TenTk = $row["TenTk"];
                $taikhoan_obj->VaiTro = $row["VaiTro"];
                $taikhoan_obj->MatKhau = $row["MatKhau"];
            }

            return $taikhoan_obj;
        }

        // Xóa Tài Khoản
    public function Xoataikhoan($conn, $baseUrl) {
        $message = "Lỗi khi Xóa thể loại";
        $sql = "DELETE FROM taikhoan WHERE MaTk = $this->MaTk";

        if (mysqli_query($conn, $sql)) {
            $message = "Xóa Tài Khoản $this->TenTk thành công";
        }

        header("Location: $baseUrl?p=taikhoan&message=" . urlencode($message));
        exit();
    }
    
    // Đổi Mật Khẩu
    public function DoiMatKhau($conn, $matKhauMoi, $baseUrl) {
        $hashedPassword = password_hash($matKhauMoi, PASSWORD_DEFAULT);
        $sql = "UPDATE taikhoan SET MatKhau='$hashedPassword' WHERE MaTk=$this->MaTk";

        $message = "Lỗi khi đổi mật khẩu";
        if (mysqli_query($conn, $sql)) {
            $message = "Đổi mật khẩu thành công";
        } else {
            $message = "Đổi mật khẩu không thành công";
        }

        header("Location: $baseUrl?p=taikhoan&message=" . urlencode($message));
        exit();
    }

    public function SuaVaiTro($conn) {
        // Chỉ cập nhật vai trò
        $sql = "UPDATE taikhoan SET VaiTro = ? WHERE MaTk = ?";
        
        // Sử dụng prepared statement để tránh SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $this->VaiTro, $this->MaTk);
        
        // Thực hiện câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Cập nhật vai trò thành công.</div>";
        } else {
            echo "<div class='alert alert-danger'>Cập nhật vai trò không thành công.</div>";
        }
        
        // Đóng prepared statement
        $stmt->close();
    }
    
    
}
?>