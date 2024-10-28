<?php
include('./dangki.php');

if(isset($_POST['oldPassword'])) {
    $currentUserId = $_SESSION['MaTk'];
    $data = new taikhoan();
    $data = $data->layTaikhoan($conn, $currentUserId);

    // Cập nhật Vai Trò
    $data->VaiTro = $_POST["VaiTro"];
    $data->SuaVaiTro($conn);

    // Đổi mật khẩu
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if(password_verify($oldPassword, $data->MatKhau)) {
        if ($newPassword === $confirmPassword) {
            $data->DoiMatKhau($conn, $newPassword, $baseUrl);
            echo "<div class='alert alert-success'>Đổi mật khẩu thành công.</div>";
        } else {
            echo "<div class='alert alert-danger'>Mật khẩu mới và xác nhận mật khẩu không khớp.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Mật khẩu cũ không đúng.</div>";
    }
} else {
    $id = ($_GET["id"]);
    $data = new taikhoan();
    $data = $data->layTaikhoan($conn, $id);
}
echo "Vai trò hiện tại: " . $data->VaiTro;
?>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background-color: #004494;
            border-color: #004494;
        }
    </style>
</head>

<div class="form-container">
    <h2>Đổi Mật Khẩu</h2>
    <form method="post">
        <div class="form-group mb-3">
            <label for="oldPassword">Mật khẩu cũ:</label>
            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
        </div>

        <div class="form-group mb-3">
            <label for="newPassword">Mật khẩu mới:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>

        <div class="form-group mb-3">
            <label for="confirmPassword">Xác nhận mật khẩu mới:</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>

        <div class="form-group">
            <label for="VaiTro">Vai Trò:</label>
            <select class="form-control" name="VaiTro" id="VaiTro">
                <option value="Quản Trị" <?php echo (trim($data->VaiTro) == 'Quản Trị') ? 'selected' : ''; ?>>Quản Trị</option>
                <option value="Giảng Viên" <?php echo (trim($data->VaiTro) == 'Giảng Viên') ? 'selected' : ''; ?>>Giảng Viên</option>
                <option value="Khoa" <?php echo (trim($data->VaiTro) == 'Khoa') ? 'selected' : ''; ?>>Khoa</option>
            </select>
        </div>



        <button type="submit" class="btn btn-primary btn-block">Đổi Mật Khẩu</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

