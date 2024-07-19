<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaDGTT = $_POST["MaDGTT"];
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];

    // Tạo mảng để chứa các tiêu chí đánh giá từ form
    $criteriaData = [
        '2_nam_hoan_thanh_nhiem_vu' => isset($_POST['2_nam_hoan_thanh_nhiem_vu']),
        'dat_danh_hieu_tap_the' => isset($_POST['dat_danh_hieu_tap_the']),
        'dong_y' => isset($_POST['dong_y']),
    ];

    // Truyền mảng tiêu chí đánh giá vào phương thức Themdanhgiatt
    $data->Themxetdanhgiattubndtp($conn, $baseUrl, $criteriaData);
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
        <label>Có 2 năm liên tục hoàn thành xuất sắc nhiệm vụ: <input type="checkbox" name="2_nam_hoan_thanh_nhiem_vu"></label><br>
        <label>Đạt danh hiệu tập thể: <input type="checkbox" name="dat_danh_hieu_tap_the"></label><br>
        <label>có 2/3 thành viên HĐ đồng ý : <input type="checkbox" name="dong_y"></label><br>
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value="Cập Nhật Đánh Giá"/>
    </div>
</form>
