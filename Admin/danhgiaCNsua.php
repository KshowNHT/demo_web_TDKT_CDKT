<?php
    include('./danhgiaCN.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaCN();
        $data->MaDGCN = $_POST["MaDGCN"];
        $data->MaKhoa = $_POST["MaKhoa"];
        $data->SoQD = $_POST["SoQD"];
        $data->Manam = $_POST["Lnam"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->Ngay = $_POST["Ngay"];
        if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $data->FilePDF = $_FILES['file'];  // Gán file PDF vào thuộc tính FilePDF
        } else {
            $data->FilePDF = null; // Nếu không có file hoặc có lỗi khi upload
        }
        $data->DonVi = $_POST["Ldonvi"];
        
        $data->Suadgcn($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new DanhgiaCN();
        $data  =  $data->laydgcn($conn,$id);
        $Lnam = Nam::layDanhSach($conn);
        $datakhoa = Khoa::layDanhSach($conn);
    }

    
    
?>

<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f6f9;
    color: #495057;
}

.container {
    max-width: 850px;
    margin: 40px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #007bff;
    font-weight: 600;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 10px;
    display: inline-block;
    font-size: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 15px;
    color: #495057;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
}

.form-group.row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.form-group.row .col {
    flex: 1;
    min-width: 200px;
}

.form-control[type="submit"] {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    padding: 12px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

.form-control[type="submit"]:hover {
    background-color: #0056b3;
}

fieldset {
    border: 1px solid #e2e2e2;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}

legend {
    padding: 0 10px;
    font-weight: 600;
    color: #007bff;
    font-size: 16px;
}


</style>
<div class="container">
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="MaDGCN">Họ Và Tên: <?php echo $data->MaCN->HoTen ?></label>
        <input type="hidden" class="form-control" id="MaDGCN" name="MaDGCN" value ='<?php echo $data->MaDGCN ;?>'readonly>
    </div>

    <div class="form-group">
            <label for="MaKhoa">Khoa: <?php echo $data->MaKhoa->TenKhoa ?></label>
    </div>

        <div class="col">
                <label >Năm</label>
                <select name="Lnam" id="Lnam">
                    <?php foreach($Lnam as $L) { ?>
                        <option value="<?php echo $L->Manam; ?>" <?php echo ($L->Manam == $data->Manam->Manam) ? 'selected' : ''; ?>>
                            <?php echo $L->Nam; ?>
                        </option>
                    <?php } ?>
                </select>
        </div>

        <div class="form-group">
            <label >Đánh Giá</label>
            <select name="DanhGia" id="DanhGia">
                <option value="Chưa Đánh Giá" <?php echo ($data->DanhGia == 'Chưa Đánh Giá') ? 'selected' : ''; ?>>Chưa Đánh Giá</option>
                <option value="Hoàn Thành Xuất Sắc" <?php echo ($data->DanhGia == 'Hoàn Thành Xuất Sắc') ? 'selected' : ''; ?>>Hoàn Thành Xuất Sắc</option>
                <option value="Hoàn Thành Tốt Nhiệm Vụ" <?php echo ($data->DanhGia == 'Hoàn Thành Tốt Nhiệm Vụ') ? 'selected' : ''; ?>>Hoàn Thành Tốt Nhiệm Vụ</option>
                <option value="Hoàn Thành Nhiệm Vụ" <?php echo ($data->DanhGia == 'Hoàn Thành Nhiệm Vụ') ? 'selected' : ''; ?>>Hoàn Thành Nhiệm Vụ</option>
                <option value="Không Hoàn Thành Nhiệm Vụ" <?php echo ($data->DanhGia == 'Không Hoàn Thành Nhiệm Vụ') ? 'selected' : ''; ?>>Không Hoàn Thành Nhiệm Vụ</option>

            </select>
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
        <label for="FilePDF">Tải Lên File PDF:</label>
        <input type="file" class="form-control" id="FilePDF" name="FilePDF">
    </div>

    <?php if (!empty($data->FilePDF)) { ?>
        <div class="form-group">
            <label for="CurrentFilePDF">File PDF Hiện Tại:</label>
            <a href="<?php echo $data->FilePDF; ?>" target="_blank">Xem File PDF</a>
        </div>
    <?php } ?>

        
    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật Đánh Giá"/>
    </div>
</form>
</div>