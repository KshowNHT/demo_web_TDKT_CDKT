<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];
    $data->Manam = $_POST["Lnam"];

    // Tạo mảng để chứa các tiêu chí đánh giá từ form
    $criteriaData = [
        'duoc_tang_hcldhb' => isset($_POST['duoc_tang_hcldhb']),
        'co_5_nam_tro_len_hoan_thanh_xsnv' => isset($_POST['co_5_nam_tro_len_hoan_thanh_xsnv']),
        'danh_hieu_ttldxs' => isset($_POST['danh_hieu_ttldxs']),
        'co_1_lan_nhan_duoc_co_thi_dua_cp' => isset($_POST['co_1_lan_nhan_duoc_co_thi_dua_cp']),
        'co_1_lan_duoc_tang_co_thi_dua_ubnd' => isset($_POST['co_1_lan_duoc_tang_co_thi_dua_ubnd']),
        'co_3_lan_duoc_tang_co_thi_dua_ubnd' => isset($_POST['co_3_lan_duoc_tang_co_thi_dua_ubnd']),
        'dong_y' => isset($_POST['dong_y'])
    ];

    // Truyền mảng tiêu chí đánh giá vào phương thức Themdanhgiatt
    $data->Themxetdanhgiahcldhn($conn, $baseUrl, $criteriaData);
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
            <label for="SoQD">Số Quyết Định:</label>
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
        <label for="duoc_tang_hcldhb">Đã được tặng “Huân chương Lao động” hạng Ba:</label>
        <input type="checkbox" id="duoc_tang_hcldhb" name="duoc_tang_hcldhb">

        <label for="co_5_nam_tro_len_hoan_thanh_xsnv">Sau đó có liên tục từ 05 năm trở lên hoàn thành XSNV:</label>
        <input type="checkbox" id="co_5_nam_tro_len_hoan_thanh_xsnv" name="co_5_nam_tro_len_hoan_thanh_xsnv">

        <label for="danh_hieu_ttldxs">Hoặc đạt danh hiệu TTLĐXS:</label>
        <input type="checkbox" id="danh_hieu_ttldxs" name="danh_hieu_ttldxs">

        <label for="co_1_lan_nhan_duoc_co_thi_dua_cp">có 01 lần được tặng “Cờ thi đua của Chính phủ”:</label>
        <input type="checkbox" id="co_1_lan_nhan_duoc_co_thi_dua_cp" name="co_1_lan_nhan_duoc_co_thi_dua_cp">

        <label for="co_1_lan_duoc_tang_co_thi_dua_ubnd">01 lần được tặng cờ thi đua của UBND:</label>
        <input type="checkbox" id="co_1_lan_duoc_tang_co_thi_dua_ubnd" name="co_1_lan_duoc_tang_co_thi_dua_ubnd">

        <label for="co_3_lan_duoc_tang_co_thi_dua_ubnd">Hoặc có 03 lần được tặng cờ thi đua của UBND:</label>
        <input type="checkbox" id="co_3_lan_duoc_tang_co_thi_dua_ubnd" name="co_3_lan_duoc_tang_co_thi_dua_ubnd">

        <label for="dong_y">Có 2/3 thành viên HĐ đồng ý:</label>
        <input type="checkbox" id="dong_y" name="dong_y">
        
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
        // if (Manam === '') {
        //     window.location.reload();
        //     return;
        // }
    $(document).ready(function(){
        $('#Lnam').change(function(){
            var year = $(this).val();
            $.ajax({
                url: 'getkhoatheodanhgiahangnhi.php',
                type: 'POST',
                data: {year: year},
                success: function(data) {
                    $('#khoa-list').html(data);
                }
            });
        });
    });
</script>