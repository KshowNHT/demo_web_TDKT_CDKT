<?php
    include('./ktkyluat.php');
    if(isset($_POST["SoQD"])){
        $data = new ktkyluat();
        $data->MaKTKL = $_POST["MaKTKL"];
        $data->KhenThuong = $_POST["KhenThuong"];
        $data->SoQuyetDinh = $_POST["SoQD"];
        $data->KyLuat = isset($_POST["KyLuat"]) ? implode(',', $_POST["KyLuat"]) : '';
        $data->Manam = $_POST["Lnam"];
        $data->GhiChu = $_POST["GhiChu"];
        $data->NgayQuyetDinh = $_POST["Ngay"];
        $data->MaKhoa = $_POST["MaKhoa"];

        if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $data->FilePDF = $_FILES['file'];  // Gán file PDF vào thuộc tính FilePDF
        } else {
            $data->FilePDF = null; // Nếu không có file hoặc có lỗi khi upload
        }
        $data->Suaktkl($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new ktkyluat();
        $data  =  $data->laydgtt($conn,$id);
    }

    $Lnam = Nam::layDanhSach($conn);
    $datakhoa = Khoa::layDanhSach($conn);
    
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
        <label for="MaKTKL">Họ Và Tên: <?php echo $data->MaCN->HoTen ?></label>
        <input type="hidden" class="form-control" id="MaKTKL" name="MaKTKL" value ='<?php echo $data->MaKTKL ;?>'readonly>
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
        <label for="KhenThuong">Khen Thưởng: </label>
        <input type="text" class="form-control" id="KhenThuong" name="KhenThuong" value="<?php echo htmlspecialchars($data->KhenThuong); ?>">
        </div>

        <div class="form-group">
            <label for="KyLuat">Kỷ Luật:</label>
            <div>
                <label><input type="checkbox" name="KyLuat[]" value="Khiển Trách" <?php echo (in_array('Khiển Trách', explode(',', $data->KyLuat))) ? 'checked' : ''; ?>> Khiển Trách</label>
            </div>
            <div>
                <label><input type="checkbox" name="KyLuat[]" value="Cảnh Cáo" <?php echo (in_array('Cảnh Cáo', explode(',', $data->KyLuat))) ? 'checked' : ''; ?>> Cảnh Cáo</label>
            </div>
        </div>


    <div class="form-group row">
        <div class="col">
            <label for="SoQD">Số Quyết Định: </label>
            <input type="text" class="form-control" id="SoQD" name="SoQD" value ='<?php echo $data->SoQuyetDinh; ?>'>
        </div>
        <div class="col">
            <label for="GhiChu">Ghi Chú: </label>
            <input type="text" class="form-control" id="GhiChu" name="GhiChu" value ='<?php echo $data->GhiChu; ?>'>
        </div>

        <div class="col">
        <label for="Ngay">Ngày :</label>
        <input type="date" class="form-control" id="Ngay" name="Ngay" value="<?php echo $data->NgayQuyetDinh; ?>">
        </div>

        <div class="col">
            <label for="MaKhoa">Đơn Vị: <?php echo $data->MaKhoa->TenKhoa ?></label>
            <input type="hidden" class="form-control" id="MaKhoa" name="MaKhoa" value ='<?php echo $data->MaKhoa->MaKhoa; ?>' readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="FilePDF">Tải Lên File PDF:</label>
        <input type="file" class="form-control" id="FilePDF" name="FilePDF">
    </div>

    <!-- Nếu có file PDF hiện tại, hiển thị nút để xem -->
    <?php if (!empty($data->FilePDF)) { ?>
        <div class="form-group">
            <label for="CurrentFilePDF">File PDF Hiện Tại:</label>
            <a href="<?php echo $data->FilePDF; ?>" target="_blank">Xem File PDF</a>
        </div>
    <?php } ?>

        
    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật"/>
    </div>
</form>
</div>