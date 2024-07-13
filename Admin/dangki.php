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






}
?>