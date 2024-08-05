<?php
include('./danhgiaTT.php');
$data = DanhgiaTT::laydanhsachdanhgiahieutruong($conn);

// Mảng ánh xạ
$awardMap = array(
    'GK_Hieu_Truong' => 'Giấy Khen Hiệu Trưởng',
);

if (isset($_GET["message"])) {
    $message = $_GET["message"];
?>
    <span class="badge badge-primary">
        <?php echo $message ?>
    </span>
<?php
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên Khoa</th>
            <th>Số Quyết Định</th>
            <th>Năm</th>
            <th>Đánh Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $item) {
            // Lấy giá trị đánh giá từ mảng ánh xạ
            $danhGia = isset($awardMap[$item->DanhGia]) ? $awardMap[$item->DanhGia] : $item->DanhGia;
        ?>
            <tr>
                <td scope="row"><?php echo $item->MaKhoa; ?></td>
                <td><?php echo $item->SoQD ?? "Cần Thêm Số Quyết Đinh Cho $item->MaKhoa"?></td>
                <td><?php echo $item->Manam ?? "Cần Thêm Năm Cho $item->MaKhoa" ?></td>
                <td><?php echo $danhGia; ?></td> <!-- Hiển thị tên loại khen thưởng -->
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
