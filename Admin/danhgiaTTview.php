<?php  
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
include('./danhgiaTT.php');
$data = DanhgiaTT::layDanhSach($conn);

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
    <?php foreach ($data as $item): ?>
        <tr>
            <td scope="row"><?php echo $item->MaKhoa; ?></td>
            <td><?php echo $item->SoQD ?? "Cần Thêm Số Quyết Đinh Cho $item->MaKhoa" ?></td>
            <td><?php echo $item->Manam ?? "Cần Thêm Năm Cho $item->MaKhoa" ?></td>
            <td><?php echo $item->DanhGia; ?></td> 
            <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'): ?> 
                <td>
                    <button type="button" class="btn btn-info">
                        <a href='<?php echo "$baseUrl?p=danhgiaTTsua&&id=$item->MaDGTT" ?>'>Sửa Đánh Giá</a>
                    </button>
                </td>
                <?php if($item->DanhGia == "Không Hoàn Thành Nhiệm Vụ"): ?>
                    <td>
                    <button type="button" class="btn btn-info">Không thể xét đánh giá cho Khoa <?php echo $item->MaKhoa; ?></button>
                    </td> 
                <?php else: ?>
                    <td>
                        <button type="button" class="btn btn-info">
                            <a href='<?php echo "$baseUrl?p=xetdanhgiaTT&&id=$item->MaDGTT" ?>'>Xét Đánh Giá</a>
                        </button>
                    </td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
