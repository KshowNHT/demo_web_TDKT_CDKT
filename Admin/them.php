<?php ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Khen Thưởng </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
  <script src="https://kit.fontawesome.com/ba73e27adb.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- <link href="../Admin/asset/css/mycss.css" rel="stylesheet"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <title>Tổng Hợp Thi Đua Khen Thưởng </title>
</head>
<body class="control-sidebar-slide-open  text-sm sidebar-mini layout-fixed  " style="height: auto;">

<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php
      include('../Admin/navbar.php')
    ?>
  </nav>
  <div class="content-wrapper">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php
        include('../Admin/menu.php')
      ?>
    </aside>

    <section class="content">
      <?php
          include('../Admin/section.php')
      ?>
    </section>
  </div>
</div>

<footer class="main-footer">
<?php
        include('../Admin/footer.php')
?>
</footer>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
</body>
</html>