<?php  
include('./danhgiaTT.php');
$data = DanhgiaTT::laydanhsachdanhgiahieutruong($conn);

if (isset($_GET["message"])) {
    $message = $_GET["message"];
?>
    <span class="badge badge-primary">
        <?php echo $message ?>
    </span>
<?php
}
?>

<table class="table">
    <thead>
        <tr>
            <th>Tên Khoa</th>
            <th>Số Quyết Định</th>
            <th>Đánh Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $item) {
        ?>
            <tr>
                <td scope="row"><?php echo $item->MaKhoa; ?></td>
                <td><?php echo $item->SoQD ?? "Cần Thêm Số Quyết Đinh Cho $item->MaKhoa"?></td>
                <td><?php echo $item->DanhGia; ?></td> <!-- Hiển thị tên loại khen thưởng -->
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
                <td><button type="button" class="btn btn-info"><a href='<?php echo "$baseUrl?p=xetdanhgiaTTsua&&id=$item->MaDGTT" ?>'>Sửa Đánh Giá</a> </button></td>
                <td><button type="button" class="btn btn-info"><a href='<?php echo "$baseUrl?p=danhgiaTThubndtpthem&&id=$item->MaDGTT" ?>'>Xét Đánh Giá</a> </button></td>
                <?php
               }
               ?>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
