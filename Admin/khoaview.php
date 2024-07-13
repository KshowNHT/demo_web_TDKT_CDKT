<?php  
    include('./Khoa.php');
    $data = Khoa::layDanhSach($conn);


    if (isset($_GET["message"])) {
        $message = $_GET["message"];
?>
        <span class="badge badge-primary">
            <?php echo $message ?>
        </span>
<?php
    }
?>
<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
<a class="btn btn-primary btn-lg" href="<?php echo " $baseUrl?p=Khoath"; ?>">Thêm Khoa</a>
<?php
}
?>
<table class="table">
    <thead>
        <tr>
            <th>Tên Khoa</th>
            <th>Mô Tả</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data as $item)
            {
        ?>
            <tr>
                <td scope="row"><?php echo $item->TenKhoa ;?></td>
                <td><?php echo $item->MoTa;?></td>
                <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị'){?> 
                <td><a href='<?php echo "$baseUrl?p=danhgiaTTth&&id=$item->MaKhoa" ?>'>Cập Nhật Đánh Giá</a> |<a href='<?php echo "$baseUrl?p=Khoasua&&id=$item->MaKhoa" ?>'>Sửa</a> | <a href='<?php echo "$baseUrl?p=Khoaxoa&&id=$item->MaKhoa" ?>'>Xóa</a></td>
                <?php
                    }
                ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>