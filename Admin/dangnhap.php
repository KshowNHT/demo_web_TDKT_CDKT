<?php
 if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include ('../Admin/connectdb.php');

// $baseUrl = $pages;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['TenTk']) && !empty($_POST['MatKhau'])) {
        $TenTk = $_POST['TenTk'];
        $MatKhau = $_POST['MatKhau'];
        

        // Sử dụng prepared statement 
        $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE TenTk = ?");
        $stmt->bind_param("s", $TenTk);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($MatKhau, $row['MatKhau'])) {
                $_SESSION['TenTk'] = $TenTk;
                $_SESSION['VaiTro'] = $row['VaiTro'];
                header("Location: ../Admin/index.php");
                exit();
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu.";
            }
        } else {
            $error = "Tài khoản không tồn tại.";
        }
        $stmt->close();
    } else {
        $error = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                    </div>
                                    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
                                    <form class="user" action="dangnhap.php" method="POST">
                                        <input type="hidden" name="form_login" value="true">
                                        <input type="text" class="form-control form-control-user" id="TenTk" placeholder="Enter NameUser Address..." name="TenTk" required>
                                        <input type="password" class="form-control form-control-user" id="MatKhau" placeholder="Password" name="MatKhau" required>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD
