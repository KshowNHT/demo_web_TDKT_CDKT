<?php

    class Nam {
        public $Manam;
        public $Nam;


        public static function layDanhSach($conn) 
        {

            $Dsnam = array();
            $sql = "SELECT * FROM `nam`";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                // Lặp qua các dòng kết quả
                while($row = $result->fetch_assoc()) {
                    // Tạo đối tượng danh mục và đưa vào mảng
                    $nam_obj = new Nam();
                    $nam_obj->Manam = $row["Manam"];
                    $nam_obj->Nam = $row["Nam"];
                    $Dsnam[] = $nam_obj;
                }
            }
    
            return $Dsnam;

        }
        //lấy thông tin Khoa 
        public static function laynam($conn, $id) {
            // Chuẩn bị câu truy vấn SQL để lấy thông tin 
            $sql = "SELECT * FROM nam WHERE Manam = $id";
        
            // Thực hiện câu truy vấn và lấy kết quả
            $result = mysqli_query($conn, $sql);
 
            $nam = new Nam();
            $row = mysqli_fetch_assoc($result);
            $nam->Manam = $row['Manam'];
            $nam->Nam = $row['Nam'];
            // Trả về đối tượng 
            return $nam;
        }

        // Thêm Sản Phẩm Vào Năm
        public function Themnam($conn,$baseUrl) {
            
            // Thông báo cần gửi
            $message = "Lỗi khi thêm thể loại";
        

            // tạo câu truy vấn để thêm đối tượng thể loại mới vào cơ sở dữ liệu
            $sql = "INSERT INTO nam (Nam) VALUES ('$this->Nam')";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Thêm Năm $this->Nam thành công";
            }else{$message = "Thêm Năm $this->Nam không thành công";}
            // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=Nam&message=" . urlencode($message));
            exit();
        }
        //Sửa Năm
        public function Suanam($conn,$baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Sửa thể loại";
            // Chuẩn bị câu truy vấn SQL để cập nhật thông tin 
            $sql = "UPDATE nam SET Nam = '$this->Nam' WHERE Manam = $this->Manam";
        
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Sửa Năm $this->Nam thành công";
            }else{$message = "Sửa Năm $this->Nam không thành công";}
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=Nam&message=" . urlencode($message));
            exit();
        }

        //Xóa Năm

        public function Xoanam($conn, $baseUrl) {
            // Thông báo cần gửi
            $message = "Lỗi khi Xóa thể loại";

            // Chuẩn bị câu truy vấn SQL để xóa 
            $sql = "DELETE FROM nam WHERE Manam = $this->Manam";
            
            // thực thi câu truy vấn và kiểm tra kết quả
            if (mysqli_query($conn, $sql)) {
                $id = mysqli_insert_id($conn);
                $message = "Xóa Năm $this->Nam thành công";
            }else{$message = "Xóa Năm $this->Nam không thành công";}
             // Chuyển hướng trang và truyền thông báo qua URL
            header("Location: $baseUrl?p=Nam&message=" . urlencode($message));
            exit();
        }

        // Lấy dữ liệu Khoa theo MaKhoa và trả về JSON
        public static function layKhoaTheoNam($conn, $Manam) {
            $sql = "SELECT * FROM danhgiatt WHERE Manam = '$Manam'";
            $result = $conn->query($sql);
    
            $khoaData = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $khoaData[] = $row;
                }
            }
    
            echo json_encode($khoaData);
        }



    }
    if (isset($_GET['Manam'])) {
        include('./connectdb.php'); // Đảm bảo rằng bạn đã bao gồm tệp kết nối database
        $Manam = $_GET['Manam'];
        Nam::layKhoaTheoNam($conn, $Manam);
    }
    

?>