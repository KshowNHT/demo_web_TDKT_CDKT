<?php
include('./connectdb.php'); 
include('./Khoa.php');

if(isset($_POST['year'])) {
    $year = $_POST['year'];

    // Truy vấn để lấy giá trị 'Nam' dựa trên 'year'
    $sql = "SELECT Nam FROM nam WHERE Manam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Kiểm tra nếu không có kết quả từ truy vấn
    if ($row) {
        $nam = $row['Nam'];

        $datakhoa = Khoa::layDanhSachChuaDanhGia($conn, $year);

        if ($datakhoa) {
            // Bắt đầu bảng
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th><input type="checkbox" id="checkAll"> Chọn tất cả</th>'; // Thêm checkbox "Chọn tất cả"
            echo '<th>Tên Khoa</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Lặp qua các dữ liệu và tạo hàng trong bảng
            foreach($datakhoa as $item) {
                echo '<tr>';
                echo '<td><input type="checkbox" class="form-check-input" name="MaKhoa[]" value="'. $item->MaKhoa.'"></td>';
                echo '<td>' . $item->TenKhoa . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>'; // Kết thúc bảng
            
            echo 'Danh sách các khoa chưa đánh giá cho năm '.$nam;
        } else {
            echo '<h5 style="color: #007bff; margin-top: 20px;">Các Khoa Trong Năm '.$nam.' Đã Được Đánh Giá</h5>';
        }
    } else {
        echo '<h5 style="color: Red; margin-top: 20px;">Vui Lòng Chọn Năm Để Đánh Giá Các Khoa</h5>';
    }

} else {
    echo 'Year not set!';
}
?>

<script>
    $(document).ready(function() {
        // Checkbox "Chọn tất cả"
        $('#checkAll').click(function() {
            if ($(this).is(':checked')) {
                $('input[name="MaKhoa[]"]').prop('checked', true);
            } else {
                $('input[name="MaKhoa[]"]').prop('checked', false);
            }
        });
    });
</script>
