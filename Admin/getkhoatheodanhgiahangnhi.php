<?php
include('./connectdb.php'); 
include('./Khoa.php');

if(isset($_POST['year']) && isset($_POST['danhGia'])) {
    // Xác thực và lọc đầu vào
    $year = filter_var($_POST['year'], FILTER_VALIDATE_INT);
    $danhGia = htmlspecialchars($_POST['danhGia']);

    // Truy vấn để lấy giá trị 'Nam' dựa trên 'year'
    $sql = "SELECT Nam FROM nam WHERE Manam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $nam = $row['Nam'];

        // Lấy danh sách các khoa chưa được đánh giá theo 'danhGia' trong năm đã chọn
        $datakhoa = Khoa::layDanhSachChuaDanhGiaTheoLoai($conn, $year, $danhGia);

        // Kiểm tra và hiển thị danh sách
        if (is_array($datakhoa) && count($datakhoa) > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th><input type="checkbox" id="checkAll"> Chọn tất cả</th>';
            echo '<th>Tên Khoa</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach($datakhoa as $item) {
                echo '<tr>';
                echo '<td><input type="checkbox" class="form-check-input" name="MaKhoa[]" value="'. $item->MaKhoa .'"></td>';
                echo '<td>' . $item->TenKhoa . '</td>';


                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo 'Danh sách các khoa chưa đánh giá '.$danhGia.' cho năm '.$nam;
        } else {
            echo '<h5 style="color: #007bff; margin-top: 20px;">Tất cả các Khoa đã được đánh giá '.$danhGia.' trong năm '.$nam.'</h5>';
        }
    } else {
        echo '<h5 style="color: Red; margin-top: 20px;">Vui Lòng Chọn Năm và Đánh Giá Để Hiển Thị Các Khoa</h5>';
    }

} else {
    echo 'Year or DanhGia not set!';
}

?>

<script>
    $(document).ready(function() {
        // Checkbox "Chọn tất cả"
        $('#checkAll').click(function() {
            $('input[name="MaKhoa[]"]').prop('checked', this.checked);
        });
    });
</script>
