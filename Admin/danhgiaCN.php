<?php
    include('./thongtincanhan.php');

    class DanhgiaCN {
        public $MaDGCN;
        public $MaCN;
        public $MaKhoa;
        public $SoQD;
        public $DanhGia;


        public static function layDanhSach($conn) 
        {

                // Lấy danh sách Đánh Giá Cá Nhân
            $sql = "SELECT * FROM `danhgiacn`";
            $result = $conn->query($sql);

            $danhgiacnList = array();
        
            // Kiểm tra số lượng Đánh Giá Cá Nhân trả về
            if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                // Đánh Giá Cá Nhân vào danh sách
                // Tạo đối tượng Khoa và đưa vào mảng
                $thongtincanhan_obj = thongtincanhan::laythongtincanhan($conn,$row["MaCN"]);
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $danhgiacn_obj = new DanhgiaCN();
                $danhgiacn_obj->MaDGCN = $row["MaDGCN"];
                $danhgiacn_obj->MaCN = $thongtincanhan_obj->HoTen;
                $danhgiacn_obj->MaKhoa = $khoa_obj->TenKhoa;
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
                $khoa_obj = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $danhgiacn_obj = new DanhgiaCN();
                $danhgiacn_obj->MaDGCN = $row["MaDGCN"];
                $danhgiacn_obj->MaCN = $thongtincanhan_obj->HoTen;
                $danhgiacn_obj->MaKhoa = $khoa_obj->TenKhoa;
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
        $danhgiacn_obj->SoQD = $row["SoQD"];
        $danhgiacn_obj->DanhGia = $row["DanhGia"];
        // Trả về đối tượng Đánh Giá Tập Thể
        return $danhgiacn_obj;
        }
        //Thêm Đánh Giá Cá nhân
        public function Themdanhgiacn($conn,$baseUrl) {
            
            // Thông báo cần gửi
            $message = "Lỗi khi thêm thể loại";
        

            // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
            $sql = "INSERT INTO danhgiacn (MaCN, MaKhoa, SoQD, DanhGia) VALUES ('$this->MaCN', '$this->MaKhoa', '$this->SoQD', '$this->DanhGia')";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Đánh Giá $this->MaCN thành công";
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
            $sql = "UPDATE danhgiacn SET SoQD = '$this->SoQD', DanhGia = '$this->DanhGia' WHERE MaDGCN = $this->MaDGCN";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Cập Đánh Giá $this->MaCN thành công";
            }
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=danhgiaCN&message=" . urlencode($message));
            exit();
        }

    }


?>