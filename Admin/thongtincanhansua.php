<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    include('./thongtincanhan.php');
    // Kiểm tra kết nối và biến baseUrl
    if (!isset($conn) || !isset($baseUrl)) {
        die("Lỗi kết nối cơ sở dữ liệu hoặc baseUrl không được đặt.");
    }
    if(isset($_POST["HoTen"])){
        $data = new thongtincanhan();
        $data->MaCN = $_POST["MaCN"];
        $data->HoTen = $_POST["HoTen"];
        $data->NgaySinh = $_POST["NgaySinh"];
        $data->MaKhoa = $_POST["LKhoa"];
        $data->ChuVu = $_POST["ChuVu"];
        $data->Suathongtincanhan($conn,$baseUrl);
    }else if(isset($_GET["id"])){
        $id = ($_GET["id"]);
        $data = new thongtincanhan();
        $data  =  $data->laythongtincanhan($conn,$id);
        
    }
?>

<?php

    $ListKhoa = Khoa::layDanhSach($conn);

?>

<form method="post">
    <div class="form-group">
        <label for="MaCN">Mã Cá Nhân: </label>
        <input type="text" class="form-control" id="MaCN" name="MaCN" value ='<?php echo $data->MaCN ;?>' readonly>
    </div>

    <div class="form-group">
        <label for="HoTen">Họ và Tên: </label>
        <input type="text" class="form-control" id="HoTen" name="HoTen" value ='<?php echo $data->HoTen ;?>'>
    </div>

    <div class="form-group">
        <label for="NgaySinh">Ngày Sinh: </label>
        <input type="text" class="form-control" id="NgaySinh" name="NgaySinh" value ='<?php echo $data->NgaySinh;?>'>
    </div>

    <div>
        <select  name="LKhoa" id="LKhoa" >
       <option value=" ">Khoa:  </option>
        <?php
        foreach($ListKhoa as $L ){
        
        ?>
       <option value="<?php echo $L->MaKhoa; ?>" <?php if ($L->MaKhoa == $data->MaKhoa->MaKhoa) echo "selected"; ?>><?php echo $L->TenKhoa; ?></option>

       <?php
        }
       ?>
     </select>
    </div>
    <div class="form-group">
        <label for="ChuVu">Chức Vụ: </label>
        <input type="text" class="form-control" id="ChuVu" name="ChuVu" value ='<?php echo $data->ChuVu ;?>'>
    </div>

    
    <div class="form-group">
        <input type="submit" class="form-control" value="Sửa Thông Tin Cá Nhân"/>
    </div>
</form>