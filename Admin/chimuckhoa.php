<?php 
    include("../Admin/connectdb.php");
    $sql = "SELECT * FROM khoa";
    $result = mysqli_query($conn, $sql);
    /* $rows = mysqli_fetch_assoc($result); */
?>

<div class="container">
    <div class="khoa" style="font-size: 16px;">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $idmaloaisp = $row['MaKhoa'] ?>
            <a href="<?php  echo "$baseUrl?p=danhgiaCNkhoa&&id= $idmaloaisp" ?>">
            <button style="font-size: 16px;" type="button" class="btn btn-primary" ><?php echo $row['TenKhoa']; ?></button>
            </a>
        <?php endwhile; ?>

    </div>
</div>