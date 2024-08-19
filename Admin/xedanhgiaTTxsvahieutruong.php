<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];
    $data->Manam = $_POST["Lnam"];

    // Tạo mảng để chứa các tiêu chí đánh giá từ form
    $criteriaData = [
        'hoan_thanh_tot_nhiem_vu' => isset($_POST['hoan_thanh_tot_nhiem_vu']),
        'ca_nhan_70_phan_tram' => isset($_POST['ca_nhan_70_phan_tram']),
        'ky_luat' => isset($_POST['ky_luat']),
        'dong_y' => isset($_POST['dong_y']),
        'hoan_thanh_xuat_sac' => isset($_POST['hoan_thanh_xuat_sac']),
        'ca_nhan_90_phan_tram' => isset($_POST['ca_nhan_90_phan_tram']),
        'ca_nhan_dat_cstdcs' => isset($_POST['ca_nhan_dat_cstdcs']),
        'ca_nhan_100_phan_tram' => isset($_POST['ca_nhan_100_phan_tram'])
    ];

    // Truyền mảng tiêu chí đánh giá vào phương thức Themdanhgiatt
    $data->Themxetdanhgiatttxsvahieutruong($conn, $baseUrl, $criteriaData);
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
        <label for="SoQD">Số Quyết Định: </label>
        <input type="text" class="form-control" id="SoQD" name="SoQD">
    </div>

    <div class="form-group">
            <label for="Lnam">Năm</label>
            <select class="form-control" name="Lnam" id="Lnam">
            <option value="">Chọn Năm</option>
                <?php foreach($Lnam as $L) { ?>
                    <option value="<?php echo $L->Manam; ?>"><?php echo $L->Nam; ?></option>
                <?php } ?>
            </select>
        </div>

    <div class="form-group flex-container">
        <label>Hoàn thành tốt Nhiệm Vụ: <input type="checkbox" id="hoan_thanh_tot_nhiem_vu" name="hoan_thanh_tot_nhiem_vu"></label>
        <label>Hoàn thành xuất sắc Nhiệm Vụ: <input type="checkbox" id="hoan_thanh_xuat_sac" name="hoan_thanh_xuat_sac"></label>
        <label>Có ít nhất 70% cá nhân đạt danh hiệu LĐTT : <input type="checkbox" id="ca_nhan_70_phan_tram" name="ca_nhan_70_phan_tram"></label>
        <label>Có 100% cá nhân trong tập thể hoàn thành nhiệm vụ : <input type="checkbox" id="ca_nhan_100_phan_tram" name="ca_nhan_100_phan_tram"></label>
        <label>Có cá nhân đạt danh hiệu CSTĐCS : <input type="checkbox" id="ca_nhan_dat_cstdcs" name="ca_nhan_dat_cstdcs"></label>
        <label>Cá nhân 90%: <input type="checkbox" id="ca_nhan_90_phan_tram" name="ca_nhan_90_phan_tram"></label>
        <label>Kỷ luật: <input type="checkbox" name="ky_luat"></label>
        <label>Đồng ý: <input type="checkbox" name="dong_y"></label>
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
                url: 'getkhoatheodanhgiaxsvsht.php',
                type: 'POST',
                data: {year: year},
                success: function(data) {
                    $('#khoa-list').html(data);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const hoanthanhtotnhiemvu = document.getElementById('hoan_thanh_tot_nhiem_vu');
    const hoanthanhxuatsac = document.getElementById('hoan_thanh_xuat_sac');
    const canhan70 = document.getElementById('ca_nhan_70_phan_tram');
    const canhan100 = document.getElementById('ca_nhan_100_phan_tram');
    const ttlcanhancstdcs = document.getElementById('ca_nhan_dat_cstdcs');
    const ttlcanhan90 = document.getElementById('ca_nhan_90_phan_tram');

    if (hoanthanhtotnhiemvu && hoanthanhxuatsac && canhan70 && canhan100 && ttlcanhancstdcs && ttlcanhan90) {
        hoanthanhtotnhiemvu.addEventListener('change', function () {
            if (hoanthanhtotnhiemvu.checked) {
                hoanthanhxuatsac.checked = false;
                hoanthanhxuatsac.disabled = true;
                canhan70.checked = false;
                canhan70.disabled = true;
                canhan100.checked = false;
                canhan100.disabled = true;
                ttlcanhancstdcs.checked = false;
                ttlcanhancstdcs.disabled = true;
            } else {
                hoanthanhxuatsac.disabled = false;
                canhan70.disabled = false;
                canhan100.disabled = false;
                ttlcanhancstdcs.disabled = false;
            }
        });

        hoanthanhxuatsac.addEventListener('change', function () {
            if (hoanthanhxuatsac.checked) {
                hoanthanhtotnhiemvu.checked = false;
                hoanthanhtotnhiemvu.disabled = true;
                ttlcanhan90.checked = false;
                ttlcanhan90.disabled = true;
            } else {
                hoanthanhtotnhiemvu.disabled = false;
                ttlcanhan90.disabled = false;
            }
        });
    } else {
        console.error("Một trong các phần tử checkbox không tồn tại trong DOM.");
    }
});


</script>