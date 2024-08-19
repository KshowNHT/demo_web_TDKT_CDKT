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

<style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }
    </style>

<form method="post">
   
<div class="container">
        <h2 class="text-center">Tạo Tài Khoản</h2>
        <form method="post">
            <div class="form-group">
                <label for="TenTk">Tên Tài Khoản:</label>
                <input type="text" class="form-control" id="TenTk" name="TenTk" required>
            </div>
            <div class="form-group">
                <label for="MatKhau">Mật Khẩu:</label>
                <input type="password" class="form-control" id="MatKhau" name="MatKhau" required>
            </div>
            <div class="form-group">
                <label for="VaiTro">Vai Trò:</label>
                <select class="form-control" name="VaiTro" id="VaiTro" required>
                    <option value="" disabled selected>Chọn vai trò</option>
                    <option value="Quản Trị">Quản Trị</option>
                    <option value="Giảng Viên">Giảng Viên</option>
                    <option value="Khoa">Khoa</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom">Tạo Tài Khoản</button>
        </form>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>