<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaDGTT = $_POST["MaDGTT"];
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];

    // Tạo mảng để chứa các tiêu chí đánh giá từ form
    $criteriaData = [
        'duoc_ubnd_tang_bang_khen' => isset($_POST['duoc_ubnd_tang_bang_khen']),
        'co_5_nam_hoan_thanh_xuat_sac' => isset($_POST['co_5_nam_hoan_thanh_xuat_sac']),
        'dat_tap_the_lao_dong_xuat_sac' => isset($_POST['dat_tap_the_lao_dong_xuat_sac']),
        'co_1_lan_duoc_tang_co_thi_dua' => isset($_POST['co_1_lan_duoc_tang_co_thi_dua']),
        'dong_y' => isset($_POST['dong_y'])
    ];

    // Truyền mảng tiêu chí đánh giá vào phương thức Themdanhgiatt
    $data->Themxetdanhgiattcp($conn, $baseUrl, $criteriaData);
} else {
    $id = $_GET["id"];
    $data = new DanhgiaTT();
    $data = $data->laydgtt($conn, $id); // Lấy thông tin đánh giá tập thể
}
?>

<form method="post">
    <div class="form-group">
        <label for="MaDGTT">Mã Đánh Giá: </label>
        <input type="text" class="form-control" id="MaDGTT" name="MaDGTT" value ='<?php echo $data->MaDGTT;?>'readonly>
    </div>
    <div class="form-group">
        <label for="MaKhoa">Mã Khoa: </label>
        <input type="text" class="form-control" id="MaKhoa" name="MaKhoa" value ='<?php echo $data->MaKhoa->MaKhoa;?>'readonly>
    </div>

    <div class="form-group">
        <label for="SoQD">Số Quyết Định: </label>
        <input type="text" class="form-control" id="SoQD" name="SoQD" value ='<?php echo $data->SoQD; ?>'readonly>
    </div>

    <div class="form-group">
        <label for="duoc_ubnd_tang_bang_khen">Được UBND tặng bằng khen:</label>
        <input type="checkbox" id="duoc_ubnd_tang_bang_khen" name="duoc_ubnd_tang_bang_khen"><br>

        <label for="co_5_nam_hoan_thanh_xuat_sac">Có 5 năm hoàn thành xuất sắc:</label>
        <input type="checkbox" id="co_5_nam_hoan_thanh_xuat_sac" name="co_5_nam_hoan_thanh_xuat_sac"> 

        <label for="dat_tap_the_lao_dong_xuat_sac">Hoặc Đạt tập thể lao động xuất sắc:</label>
        <input type="checkbox" id="dat_tap_the_lao_dong_xuat_sac" name="dat_tap_the_lao_dong_xuat_sac"><br>

        <label for="co_1_lan_duoc_tang_co_thi_dua">Có 1 lần được tặng cờ thi đua:</label>
        <input type="checkbox" id="co_1_lan_duoc_tang_co_thi_dua" name="co_1_lan_duoc_tang_co_thi_dua"><br>
        
        <label for="dong_y">Đồng ý:</label>
        <input type="checkbox" id="dong_y" name="dong_y"><br>
        
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value="Cập Nhật Đánh Giá"/>
    </div>
</form>
