
<?php
    if(isset($_POST["HoTen"])){
        include('./thongtincanhan.php');
        $data = new thongtincanhan();
        $data->HoTen = $_POST["HoTen"];
        $data->NgaySinh = $_POST["NgaySinh"];
        $data->MaKhoa = $_POST["Lkhoa"];
        $data->ChuVu = $_POST["ChuVu"];
        if(!$data->HoTen || !$data->NgaySinh|| !$data->MaKhoa || !$data->ChuVu){ 
            $error = "Vui Lòng Nhập Đầy Đủ Thông Tin.";
        }
       
        $data->Themthongtincanhan($conn,$baseUrl);
        
        
    }
?>
<?php
    include('./Khoa.php');
    $Lkhoa = Khoa::layDanhSach($conn);

?>
<?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

<form method="post" enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="HoTen">Họ và Tên: </label>
        <input type="text" class="form-control" id="HoTen" name="HoTen">
    </div>
    <div class="form-group">
        <label for="NgaySinh">Ngày Sinh: </label>
        <input type="date" class="form-control" id="NgaySinh" name="NgaySinh">
    </div>
    <div>
        <select  name="Lkhoa" id="Lkhoa" >
       <option value=" ">Khoa:  </option>
        <?php
        foreach($Lkhoa as $L ){
        ?>
       <option value="<?php echo $L->MaKhoa ;?>"><?php echo $L->TenKhoa ;?></option>

       <?php
        }
       ?>
     </select>
    </div>

    <div class="form-group">
        <label for="ChuVu">Chức Vụ: </label>
        <input type="text" class="form-control" id="ChuVu" name="ChuVu">
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value="Thêm Thông Tin Cá Nhân"/>
    </div>
</form>