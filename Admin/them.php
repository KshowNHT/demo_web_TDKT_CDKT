<?php ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Khen Thưởng </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/ba73e27adb.js" crossorigin="anonymous"></script>
  <link href="../Admin/asset/css/mycss.css" rel="stylesheet">
  <title>Tổng Hợp Thi Đua Khen Thưởng </title>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <?php
        include('../Admin/menu.php')
      ?>
    </div>

    <div class="col-sm-9">
    <?php
        include('../Admin/section.php')
    ?>
    </div>
  </div>
</div>

<footer class="container-fluid">
<?php
        include('../Admin/footer.php')
?>
</footer>

</body>
</html>