<?php  
    include('./dangki.php');
    $data = taikhoan::layDanhSach($conn);


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
<a class="btn btn-custom btn-custom-primary" href="<?php echo " $baseUrl?p=dangki"; ?>">Đăng Kí Tài Khoản</a>
<?php
}
?>

<style>
    

.btn-custom {
    background-color: #6fc3d0; /* Màu nền xanh nhạt */
    border: none; /* Loại bỏ viền */
    color: white; /* Màu chữ trắng */
    padding: 9px 13px; /* Đệm trong nút (giảm kích thước) */
    font-size: 12px; /* Cỡ chữ nhỏ hơn */
    margin: 2px; /* Khoảng cách giữa các nút */
    cursor: pointer; /* Đổi con trỏ khi hover */
    border-radius: 6px; /* Bo tròn góc nhẹ */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển màu và phóng to khi hover */
}

.btn-custom:hover {
    background-color: #5a9eac; /* Màu nền khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}

.btn-custom-danger {
    background-color: #d9534f; /* Màu đỏ nhẹ */
    }
</style>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên Tài Khoản</th>
            <th>Vai Trò</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data as $item)
            {
        ?>
            <tr>
                <td scope="row"><?php echo $item->TenTk ;?></td>
                <td scope="row"><?php echo $item->VaiTro ;?></td>
                <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị'){?> 
                <td>
                    <button class="btn btn-custom btn-custom-primary" onclick="handleActionChange('taikhoanadminsua', '<?php echo $item->MaTk; ?>', event)">Sửa Tài Khoản</button>
                    <button class="btn btn-custom btn-custom-danger" onclick="handleActionChange('taikhoanxoa', '<?php echo $item->MaTk; ?>', event)">Xóa Tài Khoản</button>
                </td>
                <?php
                    }
                ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>

<script>

function handleActionChange(action, id, event) {
    event.preventDefault(); // Ngăn không cho form submit hoặc hành động mặc định diễn ra
    if (action) {
        var baseUrl = "<?php echo $baseUrl; ?>";
        window.location.href = baseUrl + "?p=" + action + "&id=" + id;
    }
    }
</script>