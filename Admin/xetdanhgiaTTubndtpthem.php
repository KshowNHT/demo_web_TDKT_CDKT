<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaDGTT = $_POST["MaDGTT"];
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];
    $data->Manam = $_POST["Lnam"];
    $data->Ngay = $_POST["Ngay"];
    $data->DonVi = $_POST["Ldonvi"];

    // Tạo mảng để chứa các tiêu chí đánh giá từ form
    $criteriaData = [
        '2_nam_hoan_thanh_nhiem_vu' => isset($_POST['2_nam_hoan_thanh_nhiem_vu']),
        'dat_danh_hieu_tap_the' => isset($_POST['dat_danh_hieu_tap_the']),
        'dong_y' => isset($_POST['dong_y']),
    ];

    // Truyền mảng tiêu chí đánh giá vào phương thức Themdanhgiatt
    $data->Themxetdanhgiattubndtp($conn, $baseUrl, $criteriaData);
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
        <label>Có 2 năm liên tục hoàn thành xuất sắc nhiệm vụ: <input type="checkbox" id = "2_nam_hoan_thanh_nhiem_vu" name="2_nam_hoan_thanh_nhiem_vu"></label>
        <label>Hoặc Đạt danh hiệu tập thể: <input type="checkbox" id = "dat_danh_hieu_tap_the" name="dat_danh_hieu_tap_the"></label>
        <label>có 2/3 thành viên HĐ đồng ý : <input type="checkbox" name="dong_y"></label>
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
                url: 'getkhoatheodanhgiaubndtp.php',
                type: 'POST',
                data: {year: year},
                success: function(data) {
                    $('#khoa-list').html(data);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const hoanthanhnhiemvu = document.getElementById('2_nam_hoan_thanh_nhiem_vu');
        const danhhieutapthe = document.getElementById('dat_danh_hieu_tap_the');


        hoanthanhnhiemvu.addEventListener('change', function () {
            if (hoanthanhnhiemvu.checked) {
                danhhieutapthe.checked = false;
                danhhieutapthe.disabled = true;
            } else {
                danhhieutapthe.disabled = false;
            }
        });

        danhhieutapthe.addEventListener('change', function () {
            if (danhhieutapthe.checked) {
                hoanthanhnhiemvu.checked = false;
                hoanthanhnhiemvu.disabled = true;
            } else {
                hoanthanhnhiemvu.disabled = false;
            }
        });
    });


</script>