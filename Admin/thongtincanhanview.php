<?php
    // session_start();  
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    include('./thongtincanhan.php');
    $data = thongtincanhan::layDanhSach($conn);


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
<a class="btn btn-primary btn-lg" href="<?php echo " $baseUrl?p=thongtincanhanth"; ?>">Thêm Thông Tin</a>
<?php
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Họ Và Tên</th>
            <th>Ngày Sinh</th>
            <th>Khoa</th>
            <th>Chức Vụ</th>
    </thead>
    <tbody>
        <?php
            foreach($data as $item)
            {
        ?>
            <tr>
            <td scope="row"><?php echo $item->HoTen;?></td>
                <td><?php echo date_format(date_create($item->NgaySinh), "d/m/Y");?></td>
                <td><?php echo $item->MaKhoa ?? "Cần Thêm Khoa Cho $item->HoTen";?></td>
                <td><?php echo $item->ChuVu;?></td>
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?>
                <td><a href='<?php echo "$baseUrl?p=danhgiaCNthem&&id=$item->MaCN" ?>'>Cập Nhật Đánh Giá</a>|<a href='<?php echo "$baseUrl?p=thongtincanhansua&&id=$item->MaCN" ?>'>Sửa</a> | <a href='<?php echo "$baseUrl?p=thongtincanhanxoa&&id=$item->MaCN" ?>'>Xóa</a></td>
                <?php
                }
                ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table> 