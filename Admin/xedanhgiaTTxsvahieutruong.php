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
        <label>Hoàn thành tốt Nhiệm Vụ: <input type="radio" name="hoan_thanh_tot_nhiem_vu"></label><br>
        <label>Hoàn thành xuất sắc: <input type="radio" name="hoan_thanh_xuat_sac"></label><br>
        <label>Có 70% cá nhân đạt danh hiệu LĐTT : <input type="radio" name="ca_nhan_70_phan_tram"></label><br>
        <label>Có 100% cá nhân trong tập thể hoàn thành nhiệm vụ : <input type="radio" name="ca_nhan_100_phan_tram"></label><br>
        <label>Có cá nhân đạt danh hiệu CSTĐCS : <input type="radio" name="ca_nhan_dat_cstdcs"></label><br>
        <label>Cá nhân 90%: <input type="radio" name="ca_nhan_90_phan_tram"></label><br>
        <label>Kỷ luật: <input type="radio" name="ky_luat"></label><br>
        <label>Đồng ý: <input type="radio" name="dong_y"></label><br>
        
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value="Cập Nhật Đánh Giá"/>
    </div>
</form>
