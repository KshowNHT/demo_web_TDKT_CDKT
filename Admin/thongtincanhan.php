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
                $Khoa = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $thongtincanhan_obj = new thongtincanhan();
                $thongtincanhan_obj->MaCN = $row["MaCN"];
                $thongtincanhan_obj->HoTen = $row["HoTen"];
                $thongtincanhan_obj->NgaySinh = $row["NgaySinh"];
                $thongtincanhan_obj->MaKhoa = $Khoa->TenKhoa;
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

        public static function layTongSothongtincanhan($conn) {
            $sql = "SELECT COUNT(*) FROM thongtincanhan";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }
    
        public static function laythongtincanhanPhanTrang($conn, $startFrom, $recordsPerPage) {
            $sql = "SELECT * FROM thongtincanhan LIMIT $startFrom, $recordsPerPage";
            $result = $conn->query($sql);

            $thongtincanhanList = array();
        
            // Kiểm tra số lượng Đánh Giá Tập Thể trả về
            if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                // Thông Tin Cá Nhân vào danh sách
                // Tạo đối tượng Khoa và đưa vào mảng
                $Khoa = Khoa::layKhoa($conn,$row["MaKhoa"]);
                $thongtincanhan_obj = new thongtincanhan();
                $thongtincanhan_obj->MaCN = $row["MaCN"];
                $thongtincanhan_obj->HoTen = $row["HoTen"];
                $thongtincanhan_obj->NgaySinh = $row["NgaySinh"];
                $thongtincanhan_obj->MaKhoa = $Khoa->TenKhoa;
                $thongtincanhan_obj->ChuVu = $row["ChuVu"];
                $thongtincanhanList[] = $thongtincanhan_obj;
            }
            }
            return $thongtincanhanList;
        }

        //lấy Thông Tin Cá Nhân Theo Từng Khoa 
        public static function layDanhSachthongtintheokhoa($conn, $khoa, $nam) {
            $sql = "SELECT t.*, k.TenKhoa 
                    FROM thongtincanhan t 
                    INNER JOIN khoa k ON t.MaKhoa = k.MaKhoa
                    WHERE k.MaKhoa = ?
                    AND t.MaCN NOT IN (
                        SELECT d.MaCN 
                        FROM danhgiacn d 
                        INNER JOIN nam n ON d.Manam = n.Manam
                        WHERE d.MaKhoa = ?
                        AND d.Manam = ?
                        AND d.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá')
                    )";
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param("iii", $khoa, $khoa, $nam);
            
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];
            
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
            
            return $data;
        }
        
        //lấy Thông Tin Cá Nhân Theo Từng Khoa và Năm
    public static function layDanhSachthongtintheokhoaVaNam($conn, $khoa, $nam, $danhgia) {
    $sql = "SELECT t.*, k.TenKhoa 
            FROM thongtincanhan t 
            INNER JOIN khoa k ON t.MaKhoa = k.MaKhoa 
            WHERE k.MaKhoa = ?
            AND t.MaCN IN (
                SELECT d.MaCN 
                FROM danhgiacn d 
                WHERE d.MaKhoa = ? 
                AND d.MaNam = ?
                AND d.DanhGia IN ('Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Lao Động Tiên Tiến', 'Giấy Khen Hiệu Trưởng', 'Chiến Sĩ Thi Đua Cơ Sở', 'Chiến Sĩ Thi Đua Thành Phố', 'Chiến Sĩ Thi Đua Toàn Quốc','Bằng Khen Ủy Ban Nhân Thành Phố', 'Bằng Khen Thủ Tướng Chính Phủ', 'Huân Chương Lao Động Hạng Ba','Huân Chương Lao Động Hạng Nhì')
            )
            AND t.MaCN NOT IN (
                SELECT d.MaCN 
                FROM danhgiacn d 
                WHERE d.MaKhoa = ? 
                AND d.MaNam = ?
                AND d.DanhGia = ?
            )";
    
    $stmt = $conn->prepare($sql);
    
    // Liên kết các tham số: $khoa và $nam sẽ được sử dụng nhiều lần
    $stmt->bind_param("iiiiis", $khoa, $khoa, $nam, $khoa, $nam, $danhgia);
    
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    
    // Lưu kết quả vào mảng $data
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }
    
    return $data;
}

        
        

    }

?>