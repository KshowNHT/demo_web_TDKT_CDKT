<?php
include('./danhgiaTT.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra các trường bắt buộc có được điền đầy đủ hay không
    if (empty($_POST["SoQD"]) || empty($_POST["Lnam"]) || empty($_POST["MaKhoa"])|| empty($_POST["Ngay"])||empty($_POST["Ldonvi"])) {
        $error_message = "Vui lòng điền đầy đủ thông tin bắt buộc.";
    } else {
        // Tạo đối tượng DanhgiaTT và xử lý dữ liệu
        $data = new DanhgiaTT();
        $data->MaKhoa = $_POST["MaKhoa"];
        $data->SoQD = $_POST["SoQD"];
        $data->Manam = $_POST["Lnam"];
        $data->Ngay = $_POST["Ngay"];
        $data->DonVi = $_POST["Ldonvi"];

        $criteriaData = [
            'duoc_ubnd_tang_bang_khen' => isset($_POST['duoc_ubnd_tang_bang_khen']),
            'co_5_nam_hoan_thanh_xuat_sac' => isset($_POST['co_5_nam_hoan_thanh_xuat_sac']),
            'dat_tap_the_lao_dong_xuat_sac' => isset($_POST['dat_tap_the_lao_dong_xuat_sac']),
            'co_1_lan_duoc_tang_co_thi_dua' => isset($_POST['co_1_lan_duoc_tang_co_thi_dua']),
            'dong_y' => isset($_POST['dong_y'])
        ];

        $data->Themxetdanhgiattcp($conn, $baseUrl, $criteriaData);
        $success_message = "Cập nhật đánh giá thành công!";
    }
}

$Lnam = Nam::layDanhSach($conn);
$datakhoa = Khoa::layDanhSach($conn);
?>


<style>
.container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group.row.flex-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .form-group.row.flex-container .col {
        flex: 1;
    }
    .form-control {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group input[type="checkbox"] {
        margin-right: 10px;
    }

    .form-group.flex-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-group.flex-container label {
        flex-basis: 48%;
        display: flex;
        align-items: center;
    }

    .form-check {
        display: flex;
        flex-direction: column;
    }

    .form-check label {
        margin-bottom: 10px;
    }

    .form-control[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .form-control[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<div class="container">
<form method="post">
    <h2>Đánh Giá Thành Tích</h2>
    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>

    <?php if (!empty($success_message)) { ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="Lnam">Năm</label>
        <select class="form-control" name="Lnam" id="Lnam">
            <option value="">Chọn Năm</option>
            <?php foreach($Lnam as $L) { ?>
                <option value="<?php echo $L->Manam; ?>"><?php echo $L->Nam; ?></option>
            <?php } ?>
        </select>
    </div>
            
    <div class="form-group row flex-container">
            <div class="col">
                <label for="SoQD">Số Quyết Định:</label>
                <input type="text" class="form-control" id="SoQD" name="SoQD">
            </div>
            <div class="col">
                <label for="Ngay">Ngày:</label>
                <input type="date" class="form-control" id="Ngay" name="Ngay">
            </div>
            <div class="col">
                <label for="Ldonvi">Đơn Vị:</label>
                <select class="form-control" name="Ldonvi" id="Ldonvi">
                    <option value="">Chọn Đơn Vị</option>
                    <?php foreach($datakhoa as $L) { ?>
                        <option value="<?php echo $L->TenKhoa; ?>"><?php echo $L->TenKhoa; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

    <div class="form-group flex-container">
        <label for="duoc_ubnd_tang_bang_khen">Được UBND tặng bằng khen:</label>
        <input type="checkbox" id="duoc_ubnd_tang_bang_khen" name="duoc_ubnd_tang_bang_khen">

        <label for="co_5_nam_hoan_thanh_xuat_sac">Có 5 năm hoàn thành xuất sắc:</label>
        <input type="checkbox" id="co_5_nam_hoan_thanh_xuat_sac" name="co_5_nam_hoan_thanh_xuat_sac"> 

        <label for="dat_tap_the_lao_dong_xuat_sac">Hoặc Đạt tập thể lao động xuất sắc:</label>
        <input type="checkbox" id="dat_tap_the_lao_dong_xuat_sac" name="dat_tap_the_lao_dong_xuat_sac">

        <label for="co_1_lan_duoc_tang_co_thi_dua">Có 1 lần được tặng cờ thi đua:</label>
        <input type="checkbox" id="co_1_lan_duoc_tang_co_thi_dua" name="co_1_lan_duoc_tang_co_thi_dua">
        
        <label for="dong_y">Đồng ý:</label>
        <input type="checkbox" id="dong_y" name="dong_y"><br>
        
    </div>
    
    <div class="form-group">
            <label>Chọn Khoa</label>
            <div class="form-check" id="khoa-list">
            <h5 style="color: Red; margin-top: 20px;">Vui Lòng Chọn Năm Để Đánh Giá Các Khoa</h5>
            </div>
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value="Cập Nhật Đánh Giá"/>
    </div>
</form>
</div>


<script>
    $(document).ready(function(){
        $('#Lnam').change(function(){
            var year = $(this).val();
            $.ajax({
                url: 'getkhoatheodanhgiattcp.php',
                type: 'POST',
                data: {year: year},
                success: function(data) {
                    $('#khoa-list').html(data);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const hoanthanhxuatsac = document.getElementById('co_5_nam_hoan_thanh_xuat_sac');
        const datdanhhieutapthe = document.getElementById('dat_tap_the_lao_dong_xuat_sac');


        hoanthanhxuatsac.addEventListener('change', function () {
            if (hoanthanhxuatsac.checked) {
                datdanhhieutapthe.checked = false;
                datdanhhieutapthe.disabled = true;
            } else {
                datdanhhieutapthe.disabled = false;
            }
        }); 

        datdanhhieutapthe.addEventListener('change', function () {
            if (datdanhhieutapthe.checked) {
                hoanthanhxuatsac.checked = false;
                hoanthanhxuatsac.disabled = true;
            } else {
                hoanthanhxuatsac.disabled = false;
            }
        }); 
    });
</script>