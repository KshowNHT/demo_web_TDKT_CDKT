<?php
    include('./Khoa.php');

    class thongtincanhan {
        public $MaCN;
        public $HoTen;
        public $NgaySinh;
        public $MaKhoa;
        public $ChuVu;


        public static function layDanhSach($conn, $tim="") 
        {

                // Lấy danh sách Thông Tin Cá Nhân
            $sql = "SELECT * FROM thongtincanhan WHERE HoTen LIKE '%$tim%'";
            $result = $conn->query($sql);

            $thongtincanhanList = array();
        
            // Kiểm tra số lượng Đánh Giá Tập Thể trả về
            if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                // Thông Tin Cá Nhân vào danh sách
                // Tạo đối tượng Khoa và đưa vào mảng
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $thongtincanhan_obj = new thongtincanhan();
                $thongtincanhan_obj->MaCN = $row["MaCN"];
                $thongtincanhan_obj->HoTen = $row["HoTen"];
                $thongtincanhan_obj->NgaySinh = $row["NgaySinh"];
                $thongtincanhan_obj->MaKhoa = $khoa_obj->TenKhoa;
                $thongtincanhan_obj->ChuVu = $row["ChuVu"];
                $thongtincanhanList[] = $thongtincanhan_obj;
            }
            }
            return $thongtincanhanList;

        }
        //lấy thongtincanhan
        public static function laythongtincanhan($conn, $id) {
            // Chuẩn bị câu truy vấn SQL để lấy thông tin loại thongtincanhan
        $sql = "SELECT * FROM thongtincanhan WHERE MaCN = $id";
    
        // Thực hiện câu truy vấn và lấy kết quả
        $result = mysqli_query($conn, $sql);
        // Tạo đối tượng Khoa từ kết quả của câu truy vấn
        $thongtincanhan_obj = new thongtincanhan();
        $row = mysqli_fetch_assoc($result);
        $thongtincanhan_obj->MaCN = $row["MaCN"];
        $thongtincanhan_obj->HoTen = $row["HoTen"];
        $thongtincanhan_obj->NgaySinh = $row["NgaySinh"];
        $thongtincanhan_obj->ChuVu = $row["ChuVu"];
        $thongtincanhan_obj->MaKhoa = Khoa::layKhoa($conn,$row["MaKhoa"]);
        // Trả về đối tượng thongtincanhan
        return $thongtincanhan_obj;
        }

        // Thêm thông tin cá nhân
        public function Themthongtincanhan($conn,$baseUrl) {
            
            // Thông báo cần gửi
            $message = "Lỗi khi thêm thông tin cá nhân";
        

            // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
            $sql = "INSERT INTO thongtincanhan (HoTen,NgaySinh,MaKhoa,ChuVu) VALUES ('$this->HoTen', '$this->NgaySinh', '$this->MaKhoa', '$this->ChuVu' )";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Thêm thông tin cá nhân  $this->HoTen thành công";
            }
            // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=thongtincanhan&message=" . urlencode($message));
            exit();
        }
        //Sửa thông tin cá nhân
        public function Suathongtincanhan($conn,$baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Sửa thể loại";
            // Chuẩn bị câu truy vấn SQL để cập nhật thông tin 
            $sql = "UPDATE thongtincanhan SET HoTen = '$this->HoTen', NgaySinh = '$this->NgaySinh', MaKhoa = '$this->MaKhoa', ChuVu = '$this->ChuVu' WHERE MaCN = $this->MaCN";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Sửa thông tin cá nhân  $this->HoTen thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=thongtincanhan&message=" . urlencode($message));
            exit();
        }

        //Xóa Thông Tin Cá Nhân

        public function Xoathongtincanhan($conn, $baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Xóa thể loại";

            // Chuẩn bị câu truy vấn SQL để xóa 
            $sql = "DELETE FROM thongtincanhan WHERE MaCN = $this->MaCN";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Xóa thông tin cá nhân $this->HoTen thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=thongtincanhan&message=" . urlencode($message));
            exit();
        }
    }

?>