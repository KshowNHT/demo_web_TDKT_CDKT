<?php
    if(isset($_POST["TenKhoa"])){
        include('./Khoa.php');
        $data = new Khoa();
        $data->TenKhoa = $_POST["TenKhoa"];
        $data->MoTa = $_POST["MoTa"];
        $data->ThemKhoa($conn,$baseUrl);
    }
?>

<form method="post">
   
    <div class="form-group">
        <label for="TenKhoa">Tên Khoa:</label>
        <input type="text" class="form-control" id="TenKhoa" name="TenKhoa">
    </div>
    <div class="form-group">
        <label for="MoTa">Mô Tả:</label>
        <input type="text" class="form-control" id="MoTa" name="MoTa">
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value="Thêm Khoa"/>
    </div>
</form>