<?php
    include('./Khoa.php');

    class DanhgiaTT {
        public $MaDGTT;
        public $MaKhoa;
        public $SoQD;
        public $DanhGia;


        public static function layDanhSach($conn) 
        {

                // Lấy danh sách Đánh Giá Tập Thể
            $sql = "SELECT * FROM `danhgiatt`";
            $result = $conn->query($sql);

            $danhgiattList = array();
        
            // Kiểm tra số lượng Thông Tin Cá Nhân trả về
            if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                // Đánh Giá Tập Thể vào danh sách
                // Tạo đối tượng Khoa và đưa vào mảng
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $danhgiatt_obj = new DanhgiaTT();
                $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
                $danhgiatt_obj->MaKhoa = $khoa_obj->TenKhoa;
                $danhgiatt_obj->SoQD = $row["SoQD"];
                $danhgiatt_obj->DanhGia = $row["DanhGia"];

                $danhgiattList[] = $danhgiatt_obj;
            }
            }
            return $danhgiattList;

        }
        //lấy Đánh Giá Tập Thể
        public static function laydgtt($conn, $id) {
            // Chuẩn bị câu truy vấn SQL để lấy thông tin Đánh Giá Tập Thể
        $sql = "SELECT * FROM danhgiatt WHERE MaDGTT = $id";
    
        // Thực hiện câu truy vấn và lấy kết quả
        $result = mysqli_query($conn, $sql);
        // Tạo đối tượng Khoa từ kết quả của câu truy vấn
        $danhgiatt_obj = new DanhgiaTT();
        $row = mysqli_fetch_assoc($result);
        $danhgiatt_obj->MaDGTT = $row["MaDGTT"];
        $danhgiatt_obj->MaKhoa = Khoa::layKhoa($conn,$row["MaKhoa"]);
        $danhgiatt_obj->SoQD = $row["SoQD"];
        $danhgiatt_obj->DanhGia = $row["DanhGia"];
        // Trả về đối tượng Đánh Giá Tập Thể
        return $danhgiatt_obj;
        }

        public function Themdanhgiatt($conn,$baseUrl) {
            
            // Thông báo cần gửi
            $message = "Lỗi khi thêm thể loại";
        

            // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
            $sql = "INSERT INTO danhgiatt (MaKhoa, SoQD, DanhGia) VALUES ('$this->MaKhoa', '$this->SoQD', '$this->DanhGia')";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Đánh Giá $this->MaKhoa thành công";
            }
            // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
            exit();
        }
        //Cập Nhật Đánh Giá Tập Thể
        public function Suadgtt($conn,$baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Sửa thể loại";
            // Chuẩn bị câu truy vấn SQL để cập nhật thông tin 
            $sql = "UPDATE danhgiatt SET SoQD = '$this->SoQD', DanhGia = '$this->DanhGia' WHERE MaDGTT = $this->MaDGTT";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Cập Đánh Giá $this->MaKhoa thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=danhgiaTT&message=" . urlencode($message));
            exit();
        }

    }


?>