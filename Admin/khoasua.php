<?php
    include('./Khoa.php');
    if(isset($_POST["TenKhoa"])){
        $data = new Khoa();
        $data->MaKhoa = $_POST["MaKhoa"];
        $data->TenKhoa = $_POST["TenKhoa"];
        $data->MoTa = $_POST["MoTa"];
        $data->SuaKhoa($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new Khoa();
        $data  =  $data->layKhoa($conn,$id);
    }
?>

<form method="post">
    <div class="form-group">
        <label for="Ma_khoa">Mã Khoa: </label>
        <input type="text" class="form-control" id="MaKhoa" name="MaKhoa" value ='<?php echo $data->MaKhoa ;?>'readonly>
    </div>
    <div class="form-group">
        <label for="TenKhoa">Tên Khoa: </label>
        <input type="text" class="form-control" id="TenKhoa" name="TenKhoa" value ='<?php echo $data->TenKhoa ;?>'>
    </div>
    <div class="form-group">
        <label for="MoTa">Mô Tả: </label>
        <input type="text" class="form-control" id="MoTa" name="MoTa" value ='<?php echo $data->MoTa ;?>'>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value="Sửa Khoa"/>
    </div>
</form>