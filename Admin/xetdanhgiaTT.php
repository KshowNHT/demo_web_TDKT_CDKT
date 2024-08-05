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
        'hoan_thanh_nhiem_vu' => isset($_POST['hoan_thanh_nhiem_vu']),
        'ca_nhan_70_phan_tram' => isset($_POST['ca_nhan_70_phan_tram']),
        'ky_luat' => isset($_POST['ky_luat']),
        'dong_y' => isset($_POST['dong_y']),
    ];

    // Truyền mảng tiêu chí đánh giá vào phương thức Themdanhgiatt
    $data->Themxetdanhgiatttientien($conn, $baseUrl, $criteriaData);
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
        <label>Hoàn thành nhiệm vụ: <input type="radio" name="hoan_thanh_nhiem_vu"></label><br>
        <label>Cá nhân 70% đạt Danh Hiệu LĐTT: <input type="radio" name="ca_nhan_70_phan_tram"></label><br>
        <label>Có Cá Nhân Bị Kỷ luật: <input type="radio" name="ky_luat"></label><br>
        <label>Có 2/3 Thành Viên HĐ Đồng ý: <input type="radio" name="dong_y"></label><br>
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value="Cập Nhật Đánh Giá"/>
    </div>
</form>
