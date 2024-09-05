<?php
include('./connectdb.php'); 
include('./thongtincanhan.php');

if (isset($_POST['khoa'])) {
    $khoa = $_POST['khoa'];

    // Truy vấn để lấy giá trị 'TenKhoa' dựa trên 'MaKhoa'
    $sql = "SELECT * FROM khoa WHERE MaKhoa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $khoa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Kiểm tra nếu không có kết quả từ truy vấn
    if ($row) {
        $tenkhoa = $row['TenKhoa'];
    
        $datathongtin = thongtincanhan::layDanhSachthongtintheokhoa($conn, $khoa);
    
        if ($datathongtin) {
            // Bắt đầu bảng
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th><input type="checkbox" id="checkAll"> Chọn tất cả</th>'; // Thêm checkbox "Chọn tất cả"
            echo '<th>Họ Tên</th>';
            echo '<th>Ngày Sinh</th>';
            echo '<th>Đơn Vị</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
    
            // Lặp qua các dữ liệu và tạo hàng trong bảng
            foreach ($datathongtin as $item) {
                echo '<tr>';
                echo '<td><input type="checkbox" class="form-check-input" name="MaCN[]" value="'. $item->MaCN .'"></td>';
                echo '<td>' . $item->HoTen . '</td>';
                echo '<td>' . date_format(date_create($item->NgaySinh), "d/m/Y") . '</td>';
                echo '<td>' . $item->TenKhoa . '</td>';
                echo '</tr>';
            }
    
            echo '</tbody>';
            echo '</table>'; // Kết thúc bảng
    
            echo 'Danh sách các cá nhân chưa đánh giá cho khoa '.$tenkhoa;
        } else {
            echo '<h5 style="color: #007bff; margin-top: 20px;">Các cá nhân trong khoa '.$tenkhoa.' đã được đánh giá</h5>';
        }
    } else {
        echo '<h5 style="color: Red; margin-top: 20px;">Vui lòng chọn khoa để đánh giá các cá nhân</h5>';
    }
}
?>


<script>
     $(document).ready(function() {
        // Checkbox "Chọn tất cả"
        $('#checkAll').click(function() {
            if ($(this).is(':checked')) {
                $('input[name="MaCN[]"]').prop('checked', true);
            } else {
                $('input[name="MaCN[]"]').prop('checked', false);
            }
        });
    });

</script>