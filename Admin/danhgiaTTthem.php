<?php
    include('./danhgiaTT.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaTT();
        $data->MaKhoa = $_POST["MaKhoa"];
        $data->SoQD = $_POST["SoQD"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->Themdanhgiatt($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new Khoa();
        $data  =  $data->layKhoa($conn,$id);
        $tenKhoa = $data->TenKhoa; 
    }

    
?>

<form method="post">
    <div class="form-group">
        <label for="MaKhoa">Tên Khoa: </label>
        <input type="text" class="form-control" id="MaKhoa" name="MaKhoa" value ='<?php echo $data->MaKhoa;?>' readonly>
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