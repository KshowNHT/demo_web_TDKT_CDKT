<?php

    class Khoa {
        public $MaKhoa;
        public $TenKhoa;
        public $MoTa;


        public static function layDanhSach($conn) 
        {

            $Dskhoa = array();
            $sql = "SELECT * FROM `khoa`";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                // Lặp qua các dòng kết quả
                while($row = $result->fetch_assoc()) {
                    // Tạo đối tượng danh mục và đưa vào mảng
                    $Khoa_obj = new Khoa();
                    $Khoa_obj->MaKhoa = $row["MaKhoa"];
                    $Khoa_obj->TenKhoa = $row["TenKhoa"];
                    $Khoa_obj->MoTa = $row["MoTa"];
                    $Dskhoa[] = $Khoa_obj;
                }
            }
    
            return $Dskhoa;

        }
        //lấy thông tin Khoa 
        public static function layKhoa($conn, $id) {
            // Chuẩn bị câu truy vấn SQL để lấy thông tin 
            $sql = "SELECT * FROM Khoa WHERE MaKhoa = $id";
        
            // Thực hiện câu truy vấn và lấy kết quả
            $result = mysqli_query($conn, $sql);
 
            $Khoa = new Khoa();
            $row = mysqli_fetch_assoc($result);
            $Khoa->MaKhoa = $row['MaKhoa'];
            $Khoa->TenKhoa = $row['TenKhoa'];
            $Khoa->MoTa = $row["MoTa"];
            // Trả về đối tượng 
            return $Khoa;
        }

        // Thêm Sản Phẩm Vào Khoa
        public function ThemKhoa($conn,$baseUrl) {
            
            // Thông báo cần gửi
            $message = "Lỗi khi thêm thể loại";
        

            // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
            $sql = "INSERT INTO khoa (TenKhoa, MoTa) VALUES ('$this->TenKhoa', '$this->MoTa')";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Thêm Khoa $this->TenKhoa thành công";
            }
            // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=Khoa&message=" . urlencode($message));
            exit();
        }
        //Sửa Khoa
        public function SuaKhoa($conn,$baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Sửa thể loại";
            // Chuẩn bị câu truy vấn SQL để cập nhật thông tin 
            $sql = "UPDATE khoa SET TenKhoa = '$this->TenKhoa', MoTa = '$this->MoTa' WHERE MaKhoa = $this->MaKhoa";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Sửa Khoa $this->TenKhoa thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=Khoa&message=" . urlencode($message));
            exit();
        }

        //Xóa Khoa

        public function XoaKhoa($conn, $baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Xóa thể loại";

            // Chuẩn bị câu truy vấn SQL để xóa 
            $sql = "DELETE FROM khoa WHERE MaKhoa = $this->MaKhoa";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Xóa Khoa $this->TenKhoa thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=Khoa&message=" . urlencode($message));
            exit();
        }
    }

?>