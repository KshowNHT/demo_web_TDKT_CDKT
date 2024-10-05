<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
include('./danhgiaCN.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaCN();
    $data->MaCN = $_POST["MaCN"];
    $data->MaKhoa = $_POST["Lkhoa"];
    $data->Manam = $_POST["Lnam"];
    $data->SoQD = $_POST["SoQD"];
    $data->DanhGia = $_POST["DanhGia"];
    $data->Ngay = $_POST["Ngay"];
    $data->DonVi = $_POST["Ldonvi"];

    // Kiểm tra và lấy file PDF từ biến $_FILES
    if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $data->FilePDF = $_FILES['file'];  // Gán file PDF vào thuộc tính FilePDF
    } else {
        $data->FilePDF = null; // Nếu không có file hoặc có lỗi khi upload
    }
    
    $data->Themdanhgiacn($conn, $baseUrl);
} 
$Lnam = Nam::layDanhSach($conn);
$datakhoa = Khoa::layDanhSach($conn);
?>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f7f9fc; /* Màu nền tươi sáng */
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 750px;
        margin: 40px auto;
        padding: 25px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05); /* Bóng đổ nhẹ nhàng */
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #007bff; /* Màu xanh đậm hơn cho tiêu đề */
        font-weight: 700;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
        color: #555;
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

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Khoảng cách giữa các cột */
    }

    .col-md-4 {
        flex-basis: calc(33.333% - 20px); /* Đặt chiều rộng của mỗi cột là 33.33% và trừ khoảng cách giữa cột */
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 8px; /* Bo góc mạnh hơn cho nút */
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    #thongtin-list h5 {
        color: #dc3545;
        margin-top: 20px;
    }
</style>

<div class="container">
    <?php if (isset($message)) { echo "<p style='color: red;'>$message</p>"; } ?>
    <form method="post" enctype="multipart/form-data">
        <h2>Đánh Giá Thành Tích</h2>
        <div class="form-row">
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
        <label for="Lkhoa">Khoa</label>
        <select class="form-control" name="Lkhoa" id="Lkhoa">
            <option value="">Chọn Khoa</option>
            <?php foreach($datakhoa as $L) { ?>
                <option value="<?php echo $L->MaKhoa; ?>"><?php echo $L->TenKhoa; ?></option>
            <?php } ?>
        </select>
    </div>

        <div class="form-group">
            <label for="DanhGia">Đánh Giá</label>
            <select class="form-control" name="DanhGia" id="DanhGia">
                <option value="1">Đang Đánh Giá</option>
                <option value="Hoàn Thành Xuất Sắc">Hoàn Thành Xuất Sắc</option>
                <option value="Hoàn Thành Tốt Nhiệm Vụ">Hoàn Thành Tốt Nhiệm Vụ</option>
                <option value="Hoàn Thành Nhiệm Vụ">Hoàn Thành Nhiệm Vụ</option>
                <option value="Không Hoàn Thành Nhiệm Vụ">Không Hoàn Thành Nhiệm Vụ</option>
            </select>
        </div>
    </div>

        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="SoQD">Số Quyết Định:</label>
                    <input type="text" class="form-control" id="SoQD" name="SoQD">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Ngay">Ngày</label>
                    <input type="date" class="form-control" id="Ngay" name="Ngay">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Ldonvi">Đơn Vị</label>
                    <select class="form-control" name="Ldonvi" id="Ldonvi">
                        <option value="">Đơn Vị</option>
                        <?php foreach($datakhoa as $L) { ?>
                            <option value="<?php echo $L->TenKhoa; ?>"><?php echo $L->TenKhoa; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="file">Chọn file PDF:</label>
            <input type="file" name="file" id="file" accept="application/pdf">
        </div>

        <div class="form-group">
            <label>Thông Tin Cá Nhân</label>
            <div class="form-check" id="thongtin-list">
                <h5>Vui Lòng Chọn Khoa Để Đánh Giá Các Cá Nhân</h5>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary form-control" value="Cập Nhật Đánh Giá"/>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#Lkhoa').change(function(){
            var khoa = $(this).val();
            console.log('Dữ Liệu:', khoa);
            $.ajax({
                url: 'getthongtintheokhoa.php',
                type: 'POST',
                data: {khoa: khoa},
                success: function(data) {
                    $('#thongtin-list').html(data);
                }
            });
        });
    });
</script>
