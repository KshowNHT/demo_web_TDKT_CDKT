<?php 
    include("../Admin/connectdb.php");
    $sql = "SELECT * FROM khoa";
    $result = mysqli_query($conn, $sql);
    /* $rows = mysqli_fetch_assoc($result); */
?>

<div class="btn-group" role="group" aria-label="Basic example">
    <div class="btn-group" role="group" aria-label="Basic example">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $idmaloaisp = $row['MaKhoa'] ?>
            <a href="<?php  echo "$baseUrl?p=danhgiaCNkhoa&&id= $idmaloaisp" ?>">
            <button type="button" class="btn btn-secondary"><?php echo $row['TenKhoa']; ?></button>
            </a>
        <?php endwhile; ?>

    </div>
</div>