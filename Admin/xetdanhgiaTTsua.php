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
                <option value="TT_LAO_DONG_TIEN_TIEN" <?php echo ($data->DanhGia == 'TT_LAO_DONG_TIEN_TIEN') ? 'selected' : ''; ?>>Lao Đông Tiên Tiến</option>
                <option value="TT_LAO_DONG_XS" <?php echo ($data->DanhGia == 'TT_LAO_DONG_XS') ? 'selected' : ''; ?>>Lao Đông Xuất Sắc</option>
                <option value="GK_Hieu_Truong" <?php echo ($data->DanhGia == 'GK_Hieu_Truong') ? 'selected' : ''; ?>>Giấy Khen Hiệu Trưởng</option>
                <option value="BK_UBNDTP" <?php echo ($data->DanhGia == 'BK_UBNDTP') ? 'selected' : ''; ?>>Bằng Khen UBND Thành Phố</option>
                <option value="BK_TTCP" <?php echo ($data->DanhGia == 'BK_TTCP') ? 'selected' : ''; ?>>Bằng Khen Thủ Tướng Chính Phủ</option>
                <option value="Huan_Chuong_Lao_Dong_Hang_Ba" <?php echo ($data->DanhGia == 'Huan_Chuong_Lao_Dong_Hang_Ba') ? 'selected' : ''; ?>>Huân Chương Lao Động Hạng Ba</option>
                <option value="Huan_Chuong_Lao_Dong_Hang_Nhi" <?php echo ($data->DanhGia == 'Huan_Chuong_Lao_Dong_Hang_Nhi') ? 'selected' : ''; ?>>Huân Chương Lao Động Hạng Nhì</option>

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