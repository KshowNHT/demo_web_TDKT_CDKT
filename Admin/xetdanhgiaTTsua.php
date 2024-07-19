<?php
    include('./danhgiaTT.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaTT();
        $data->MaDGTT = $_POST["MaDGTT"];
        $data->SoQD = $_POST["SoQD"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->MaKhoa = $khoa_obj->MaKhoa;
        $data->Suadgtt($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new DanhgiaTT();
        $data  =  $data->laydgtt($conn,$id);
    }

    
?>

<form method="post">
    <div class="form-group">
        <label for="MaDGTT">Mã Đánh Giá: </label>
        <input type="text" class="form-control" id="MaDGTT" name="MaDGTT" value ='<?php echo $data->MaDGTT ;?>'readonly>
    </div>


    <div class="form-group">
        <label for="SoQD">Số Quyết Định: </label>
        <input type="text" class="form-control" id="SoQD" name="SoQD" value ='<?php echo $data->SoQD; ?>'>
    </div>

    <div class="form-group">
        <label >Đánh Giá</label>
        <select name="DanhGia" id="DanhGia">
            <option value="Chưa Đánh Giá">Đang Đánh Giá</option>
            <option value="TT_LAO_DONG_TIEN_TIEN">TT_LAO_DONG_TIEN_TIEN</option>
            <option value="TT_LAO_DONG_XS">TT_LAO_DONG_XS</option>
            <option value="GK_Hieu_Truong">GK_Hieu_Truong</option>
            <option value="BK_UBNDTP">BK_UBNDTP</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật Đánh Giá"/>
    </div>
</form>