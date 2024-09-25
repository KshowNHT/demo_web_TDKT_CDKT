<?php
    include('./danhgiaTT.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaTT();
        $data->MaKhoa = $_POST["MaKhoa"];  // This should be an array for multiple selections
        $data->SoQD = $_POST["SoQD"];
        $data->Manam = $_POST["Lnam"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->Ngay = $_POST["Ngay"];
        $data->DonVi = $_POST["Ldonvi"];

        // Kiểm tra và lấy file PDF từ biến $_FILES
        if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $data->FilePDF = $_FILES['file'];  // Gán file PDF vào thuộc tính FilePDF
        } else {
            $data->FilePDF = null; // Nếu không có file hoặc có lỗi khi upload
        }

        // Thực hiện thêm đánh giá vào database
        $data->Themdanhgiatt($conn, $baseUrl);
    }

    $Lnam = Nam::layDanhSach($conn);
    $datakhoa = Khoa::layDanhSach($conn);
?>

<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
    color: #343a40;
}

.container {
    max-width: 900px; /* Tăng chiều rộng container */
    margin: 40px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #007bff;
    font-weight: 700;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
    line-height: 1.5;
}

.form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px; /* Bo góc mạnh hơn */
        font-size: 16px;
        height: 40px; /* Đặt chiều cao tối thiểu cho các thẻ select */
        line-height: 1.5; /* Căn chỉnh dòng để đảm bảo nội dung không bị cắt */
        color: #555;
}

.form-group.row {
    display: flex;
    gap: 20px;
}

.form-group.row .col {
    flex: 1;
    min-width: 150px; /* Ensure a minimum width for columns */
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    outline: none;
}
.form-control select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    }

.form-group input[type="checkbox"] {
    margin-right: 12px;
}

.form-check {
    display: flex;
    flex-direction: column;
    margin-bottom: 25px;
}

.form-control[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 18px;
    line-height: 1.5;
    padding: 12px;
    margin-top: 20px;
    text-align: center;
}

.form-control[type="submit"]:hover {
    background-color: gray;
}

#khoa-list h5 {
    color: #dc3545;
    margin-top: 25px;
}



</style>

<div class="container">
    <form method="post" enctype="multipart/form-data">
        <h2>Đánh Giá Thành Tích</h2>

        <div class="form-group">
            <label for="Lnam">Năm</label>
            <select class="form-control" name="Lnam" id="Lnam">
                <option value="">Chọn Năm</option>
                <?php foreach($Lnam as $L) { ?>
                    <option value="<?php echo $L->Manam; ?>"><?php echo $L->Nam; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="DanhGia">Khen Thưởng</label>
            <select class="form-control" name="DanhGia" id="DanhGia">
                <option value="1">Đang Khen Thưởng</option>
                <option value="Tập Thể Lao Động Tiên Tiến">Tập Thể Lao Động Tiên Tiến</option>
                <option value="Tập Thể Lao Động Xuất Sắc">Tập Thể Lao Động Xuất Sắc</option>
                <option value="Giấy Khen Hiệu Trưởng">Giấy Khen Hiệu Trưởng</option>
                <option value="Bằng Khen Ủy Ban Nhân Dân Thành Phố">Bằng Khen Ủy Ban Nhân Dân Thành Phố</option>
                <option value="Bằng Khen Thủ Tướng Chính Phủ">Bằng Khen Thủ Tướng Chính Phủ</option>
                <option value="Huân Chương Lao Động Hạng Ba">Huân Chương Lao Động Hạng Ba</option>
                <option value="Huân Chương Lao Động Hạng Nhì">Huân Chương Lao Động Hạng Nhì</option>
            </select>
        </div>

        <div class="form-group row">
            <div class="col">
                <label for="SoQD">Số Quyết Định:</label>
                <input type="text" class="form-control" id="SoQD" name="SoQD">
            </div>
            <div class="col">
                <label for="Ngay">Ngày :</label>
                <input type="date" class="form-control" id="Ngay" name="Ngay">
            </div>
            <div class="col">
                <label for="Ldonvi">Đơn Vị</label>
                <select class="form-control" name="Ldonvi" id="Ldonvi">
                    <option value="">Đơn Vị</option>
                    <?php foreach($datakhoa as $L) { ?>
                        <option value="<?php echo $L->TenKhoa; ?>"><?php echo $L->TenKhoa; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="file">Chọn file PDF:</label>
            <input type="file" name="file" id="file" accept="application/pdf">
        </div>

        <div class="form-group">
            <label>Chọn Khoa</label>
            <div class="form-check" id="khoa-list">
                <h5 style="color: Red; margin-top: 20px;">Vui Lòng Chọn Năm Để Đánh Giá Các Khoa</h5>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Cập Nhật Đánh Giá">
        </div>
    </form>
</div>


<script>
$(document).ready(function(){
    // Khi giá trị của #Lnam hoặc #DanhGia thay đổi
    $('#Lnam, #DanhGia').change(function(){
        var year = $('#Lnam').val();
        var danhGia = $('#DanhGia').val();

        console.log('dữ liệu của year: ', year);
        console.log('dữ liệu của danhGia: ', danhGia);
        
        // Kiểm tra xem cả 'năm' và 'đánh giá' đã được chọn hay chưa
        if (year && danhGia) {
            // Gửi yêu cầu AJAX chỉ khi cả hai trường đều đã được chọn
            $.ajax({
                url: 'getkhoatheodanhgiahangnhi.php',
                type: 'POST',
                data: { year: year, danhGia: danhGia },
                success: function(data) {
                    console.log(data);
                    $('#khoa-list').html(data); // Hiển thị danh sách khoa
                }
            });
        } else {
            // Nếu một trong hai trường chưa được chọn, hiển thị thông báo
            $('#khoa-list').html('<h5 style="color: Red; margin-top: 20px;">Vui Lòng Chọn Năm và Đánh Giá Để Hiển Thị Các Khoa</h5>');
        }
    });
});


</script>