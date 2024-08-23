<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../Admin/connectdb.php');

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
                $_SESSION['MaTk'] = $row['MaTk'];
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
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đăng nhập - Hệ thống quản lý</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .bg-login-image {
            background: url('./images/logo.jpg') no-repeat center center;
            background-size: cover;
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
        .form-control-user {
            border-radius: 50px;
            padding: 15px;
        }
        .text-gray-900 {
            color: #3a3b45 !important;
        }
        .container {
            max-width: 900px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            border-radius: 50px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập vào hệ thống</h1>
                                    </div>
                                    <?php if (isset($error)) { echo "<div class='alert alert-danger text-center'>$error</div>"; } ?>
                                    <form class="user" action="dangnhap.php" method="POST">
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control form-control-user" id="TenTk" placeholder="Tên Tài Khoản" name="TenTk" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" class="form-control form-control-user" id="MatKhau" placeholder="Mật Khẩu" name="MatKhau" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Đăng Nhập</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
