<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
include('./danhgiaCN.php');



if (isset($_POST["SoQD"])) {
    $data = new DanhgiaCN();
    $data->MaCN = $_POST["MaCN"];
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];
    $data->DanhGia = $_POST["DanhGia"];
    $data->Themdanhgiacn($conn, $baseUrl);
} else if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $thongTinCaNhan = new thongtincanhan();
    $data = $thongTinCaNhan->laythongtincanhan($conn, $id);
    

    // Kiểm tra kết quả trả về từ hàm laythongtincanhan
    if (!$data) {
        // Xử lý lỗi, ví dụ: chuyển hướng hoặc hiển thị thông báo lỗi
        die("Không tìm thấy thông tin cá nhân.");
    }
} else {
    die("Yêu cầu không hợp lệ.");
}
if(!isset($data->MaKhoa->MaKhoa)){
    $message = "Lỗi Không Tìm Thấy Khoa.";
}

?>
<?php if (isset($message)) { echo "<p style='color: red;'>$message</p>"; } ?>
<form method="post">
    <div class="form-group">
        <label for="MaCN">Mã Cá Nhân: </label>
        <input type="text" class="form-control" id="MaCN" name="MaCN" value="<?php echo isset($data->MaCN) ? $data->MaCN : ''; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="MaKhoa">Mã Khoa: </label>
        <input type="text" class="form-control" id="MaKhoa" name="MaKhoa" value="<?php  echo $data->MaKhoa->MaKhoa?>" readonly>
    </div>

    <div class="form-group">
        <label for="SoQD">Số Quyết Định: </label>
        <input type="text" class="form-control" id="SoQD" name="SoQD">
    </div>

    <div class="form-group">
        <label >Đánh Giá</label>
        <select name="DanhGia" id="DanhGia">
            <option value="1">Đang Đánh Giá</option>
            <option value="Hoàn Thành Xuất" >Hoàn Thành Xuất</option>
            <option value="Hoàn Thành Tốt Nhiệm Vụ" >Hoàn Thành Tốt Nhiệm Vụ</option>
            <option value="Hoàn Thành Nhiệm Vụ" >Hoàn Thành Nhiệm Vụ</option>
            <option value="Không Hoàn Thành Nhiệm Vụ" >Không Hoàn Thành Nhiệm Vụ</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật Đánh Giá"/>
    </div>
</form>