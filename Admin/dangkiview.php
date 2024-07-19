<?php
    if(isset($_POST["TenTk"])){
        include('./dangki.php');
        $data = new taikhoan();
        $data->TenTk = $_POST["TenTk"];
        $data->MatKhau = $_POST["MatKhau"];
        $data->VaiTro = $_POST["VaiTro"];
        $data->ThemTK($conn,$baseUrl);
    }
?>

<form method="post">
   
    <div class="form-group">
        <label for="TenTk">Tên Tài Khoản:</label>
        <input type="text" class="form-control" id="TenTk" name="TenTk">
    </div>
    <div class="form-group">
        <label for="MatKhau">Mật Khẩu:</label>
        <input type="text" class="form-control" id="MatKhau" name="MatKhau">
    </div>
   
    <div class="form-group">
        <label >Vai Trò</label>
        <select name="VaiTro" id="VaiTro">
            <option value="1">Vai Trò: </option>
            <option value="Quản Trị" >Quản Trị</option>
            <option value="Giảng Viên" >Giảng Viên</option>
            <option value="Khoa" >Khoa</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value="Tạo Tài Khoản"/>
    </div>
</form>