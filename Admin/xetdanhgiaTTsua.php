<?php
    include('./danhgiaTT.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaTT();
        $data->MaDGTT = $_POST["MaDGTT"];
        $data->SoQD = $_POST["SoQD"];
        $data->Manam = $_POST["Lnam"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->MaKhoa = $khoa_obj->MaKhoa;
        $data->Suadgtt($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new DanhgiaTT();
        $data  =  $data->laydgtt($conn,$id);
    }

    $Lnam = Nam::layDanhSach($conn);
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

    <div>
        <label >Năm</label>
        <select  name="Lnam" id="Lnam" >
        <?php
        foreach($Lnam as $L ){
        ?>
        <option value="<?php echo $L->Manam ;?>"><?php echo $L->Nam ;?></option>

       <?php
        }
       ?>
     </select>
    </div>

    <div class="form-group">
    <label for="DanhGia">Đánh Giá: </label>
    <input type="text" class="form-control" id="DanhGia" name="DanhGia" value ='<?php echo $data->DanhGia; ?>'readonly>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value=" Cập Nhật Đánh Giá"/>
    </div>
</form>