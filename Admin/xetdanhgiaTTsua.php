<?php
    include('./danhgiaTT.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaTT();
        $data->MaDGTT = $_POST["MaDGTT"];
        $data->MaKhoa = $_POST["MaKhoa"];
        $data->SoQD = $_POST["SoQD"];
        $data->Manam = $_POST["Lnam"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->Ngay = $_POST["Ngay"];
        $data->DonVi = $_POST["Ldonvi"];
        $data->Suadgtt($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new DanhgiaTT();
        $data  =  $data->laydgtt($conn,$id);
        $khoa = Khoa::layKhoa($conn, $id);
    }

    $Lnam = Nam::layDanhSach($conn);
    $datakhoa = Khoa::layDanhSach($conn);
?>

<div class="container">
<form method="post">
    <div class="form-group">
        <input type="hidden" class="form-control" id="MaDGTT" name="MaDGTT" value ='<?php echo $data->MaDGTT ;?>'readonly>
    </div>

    <div class="form-group row">
        <div class="col">
            <label for="MaKhoa">Khoa: <?php echo $data->MaKhoa->TenKhoa ?></label>
        </div>

        

        <div class="col">
            <label >Năm</label>
            <select  name="Lnam" id="Lnam" >
            <?php
            foreach($Lnam as $L ){
            ?>
            <option value="<?php echo $L->Manam ;?>" <?php echo ($L->Manam == $data->Manam) ? 'selected' : ''; ?>>
                <?php echo $L->Nam ;?>
            </option>
        <?php
            }
        ?>
        </select>
        </div>
    
        <div class="form-group">
            <label >Đánh Giá</label>
            <select name="DanhGia" id="DanhGia">
                <option value="Chưa Đánh Giá" <?php echo ($data->DanhGia == 'Chưa Đánh Giá') ? 'selected' : ''; ?>>Chưa Đánh Giá</option>
                <option value="Tập Thể Lao Động Tiên Tiến" <?php echo ($data->DanhGia == 'Tập Thể Lao Động Tiên Tiến') ? 'selected' : ''; ?>>Lao Đông Tiên Tiến</option>
                <option value="Tập Thể Lao Động Xuất Sắc" <?php echo ($data->DanhGia == 'Tập Thể Lao Động Xuất Sắc') ? 'selected' : ''; ?>>Lao Đông Xuất Sắc</option>
                <option value="Giấy Khen Hiệu Trưởng" <?php echo ($data->DanhGia == 'Giấy Khen Hiệu Trưởng') ? 'selected' : ''; ?>>Giấy Khen Hiệu Trưởng</option>
                <option value="Bằng Khen Ủy Ban Nhân Dân Thành Phố" <?php echo ($data->DanhGia == 'Bằng Khen Ủy Ban Nhân Dân Thành Phố') ? 'selected' : ''; ?>>Bằng Khen UBND Thành Phố</option>
                <option value="Bằng Khen Thủ Tướng Chính Phủ" <?php echo ($data->DanhGia == 'Bằng Khen Thủ Tướng Chính Phủ') ? 'selected' : ''; ?>>Bằng Khen Thủ Tướng Chính Phủ</option>
                <option value="Huân Chương Lao Động Hạng Ba" <?php echo ($data->DanhGia == 'Huân Chương Lao Động Hạng Ba') ? 'selected' : ''; ?>>Huân Chương Lao Động Hạng Ba</option>
                <option value="Huân Chương Lao Động Hạng Nhì" <?php echo ($data->DanhGia == 'Huân Chương Lao Động Hạng Nhì') ? 'selected' : ''; ?>>Huân Chương Lao Động Hạng Nhì</option>

            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="SoQD">Số Quyết Định: </label>
            <input type="text" class="form-control" id="SoQD" name="SoQD" value ='<?php echo $data->SoQD; ?>'>
        </div>

        <div class="col">
        <label for="Ngay">Ngày :</label>
        <input type="date" class="form-control" id="Ngay" name="Ngay" value="<?php echo $data->Ngay; ?>">
    </div>

    <div class="col">
        <label for="Ldonvi">Đơn Vị</label>
        <select class="form-control" name="Ldonvi" id="Ldonvi">
            <option value="">Chọn Đơn Vị</option>
            <?php foreach($datakhoa as $L) { ?>
                <option value="<?php echo $L->TenKhoa; ?>" <?php echo ($L->TenKhoa == $data->DonVi) ? 'selected' : ''; ?>>
                    <?php echo $L->TenKhoa; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    </div>

    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật Đánh Giá"/>
    </div>
</form>
</div>