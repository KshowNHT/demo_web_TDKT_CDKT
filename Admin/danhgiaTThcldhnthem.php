<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaDGTT = $_POST["MaDGTT"];
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];
    $data->Manam = $_POST["Manam"];

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
        <label for="Manam">Năm: </label>
        <input type="text" class="form-control" id="Manam" name="Manam" value ='<?php echo $data->Manam->Manam; ?>'readonly>
    </div>

    <div class="form-group">
        <label for="duoc_tang_hcldhb">Đã được tặng “Huân chương Lao động” hạng Ba:</label>
        <input type="radio" id="duoc_tang_hcldhb" name="duoc_tang_hcldhb"><br>

        <label for="co_5_nam_tro_len_hoan_thanh_xsnv">Sau đó có liên tục từ 05 năm trở lên hoàn thành XSNV:</label>
        <input type="radio" id="co_5_nam_tro_len_hoan_thanh_xsnv" name="co_5_nam_tro_len_hoan_thanh_xsnv">

        <label for="danh_hieu_ttldxs">Hoặc đạt danh hiệu TTLĐXS:</label>
        <input type="radio" id="danh_hieu_ttldxs" name="danh_hieu_ttldxs"><br>

        <label for="co_1_lan_nhan_duoc_co_thi_dua_cp">có 01 lần được tặng “Cờ thi đua của Chính phủ”:</label>
        <input type="radio" id="co_1_lan_nhan_duoc_co_thi_dua_cp" name="co_1_lan_nhan_duoc_co_thi_dua_cp"><br>

        <label for="co_1_lan_duoc_tang_co_thi_dua_ubnd">01 lần được tặng cờ thi đua của UBND:</label>
        <input type="radio" id="co_1_lan_duoc_tang_co_thi_dua_ubnd" name="co_1_lan_duoc_tang_co_thi_dua_ubnd">

        <label for="co_3_lan_duoc_tang_co_thi_dua_ubnd">Hoặc có 03 lần được tặng cờ thi đua của UBND:</label>
        <input type="radio" id="co_3_lan_duoc_tang_co_thi_dua_ubnd" name="co_3_lan_duoc_tang_co_thi_dua_ubnd"><br>

        <label for="dong_y">Có 2/3 thành viên HĐ đồng ý:</label>
        <input type="radio" id="dong_y" name="dong_y"><br>
        
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value="Cập Nhật Đánh Giá"/>
    </div>
</form>
