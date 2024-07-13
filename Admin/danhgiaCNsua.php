<?php
    include('./danhgiaCN.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaCN();
        $data->MaDGCN = $_POST["MaDGCN"];
        $data->SoQD = $_POST["SoQD"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->Suadgcn($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new DanhgiaCN();
        $data  =  $data->laydgcn($conn,$id);
    }

    
?>

<form method="post">
    <div class="form-group">
        <label for="MaDGCN">Mã Cá Nhân: </label>
        <input type="text" class="form-control" id="MaDGCN" name="MaDGCN" value ='<?php echo $data->MaDGCN ;?>'readonly>
    </div>


    <div class="form-group">
        <label for="SoQD">Số Quyết Định: </label>
        <input type="text" class="form-control" id="SoQD" name="SoQD" value ='<?php echo $data->SoQD; ?>'>
    </div>

    <div class="form-group">
        <label >Đánh Giá</label>
        <select name="DanhGia" id="DanhGia">
            <option value="Chưa Đánh Giá">Đang Đánh Giá</option>
            <option value="Hoàn Thành Xuất ">Hoàn Thành Xuất</option>
            <option value="Hoàn Thành Tốt Nhiệm Vụ">Hoàn Thành Tốt Nhiệm Vụ</option>
            <option value="Hoàn Thành Nhiệm Vụ">Hoàn Thành Nhiệm Vụ</option>
            <option value="Không Hoàn Thành Nhiệm Vụ">Không Hoàn Thành Nhiệm Vụ</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật Đánh Giá"/>
    </div>
</form>