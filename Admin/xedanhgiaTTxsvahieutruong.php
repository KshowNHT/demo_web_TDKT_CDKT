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

    <div class="form-group">
        <label>Hoàn thành tốt Nhiệm Vụ: <input type="checkbox" name="hoan_thanh_tot_nhiem_vu"></label>
        <label>Hoàn thành xuất sắc: <input type="checkbox" name="hoan_thanh_xuat_sac"></label>
        <label>Có 70% cá nhân đạt danh hiệu LĐTT : <input type="checkbox" name="ca_nhan_70_phan_tram"></label>
        <label>Có 100% cá nhân trong tập thể hoàn thành nhiệm vụ : <input type="checkbox" name="ca_nhan_100_phan_tram"></label>
        <label>Có cá nhân đạt danh hiệu CSTĐCS : <input type="checkbox" name="ca_nhan_dat_cstdcs"></label>
        <label>Cá nhân 90%: <input type="checkbox" name="ca_nhan_90_phan_tram"></label>
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
</script>