<?php
    // session_start();  
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    include('./thongtincanhan.php');
    $data = thongtincanhan::layDanhSach($conn);




            // Số bản ghi trên mỗi trang
        $recordsPerPage = 10;

        // Xác định trang hiện tại
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        // Tính vị trí bắt đầu lấy dữ liệu
        $startFrom = ($currentPage - 1) * $recordsPerPage;

        // Lấy tổng số bản ghi
        $totalRecords = thongtincanhan::layTongSothongtincanhan($conn);

        // Tính tổng số trang
        $totalPages = ceil($totalRecords / $recordsPerPage);

        // Lấy dữ liệu cho trang hiện tại
        $data = thongtincanhan::laythongtincanhanPhanTrang($conn, $startFrom, $recordsPerPage);


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
<a class="btn btn-custom btn-custom-primary" href="<?php echo " $baseUrl?p=thongtincanhanth"; ?>">Thêm Thông Tin</a>
<?php
}
?>
<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?>
<a class="btn btn-custom btn-custom-primary" href="<?php echo " $baseUrl?p=danhgiaCNthem"; ?>">Xét Đánh Giá</a>
<?php
}
?>

<style>
    .pagination {
    background-color: transparent; 
    border: none;
    box-shadow: none;
}

.page-item {
    background-color: transparent; 
    border: none;
    box-shadow: none;
}

.page-link {
    background-color: transparent; 
    border: none;
    box-shadow: none;
    color: #007bff; /* Màu mặc định của liên kết */
}

.page-item.active .page-link {
    background-color: #007bff; /* Màu xanh đậm cho trang hiện tại */
    border-color: #007bff;
}


.table td {
    vertical-align: middle; /* Căn giữa nội dung trong ô theo chiều dọc */
    padding: 8px; /* Đệm trong ô để tránh bị dính quá sát */
}

.btn-group {
    display: flex; /* Hiển thị các nút dưới dạng flexbox */
    gap: 5px; /* Khoảng cách giữa các nút */
}

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

.btn-custom-primary {
    background-color: #6fc3d0; /* Màu xanh nhạt */
}

.btn-custom-danger {
    background-color: #d9534f; /* Màu đỏ nhẹ */
}



</style>
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
                <td><?php echo $item->MaKhoa  ?? "Cần Thêm Khoa Cho $item->HoTen";?></td>
                <td><?php echo $item->ChuVu;?></td>
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?>
                    <td>
                        <button class="btn btn-custom btn-custom-primary" onclick="handleActionChange('sangkienth', '<?php echo $item->MaCN; ?>', event)">Thêm Sáng Kiến</button>
                        <button class="btn btn-custom btn-custom-primary" onclick="handleActionChange('thongtincanhansua', '<?php echo $item->MaCN; ?>', event)">Sửa</button>
                        <button class="btn btn-custom btn-custom-danger" onclick="handleActionChange('thongtincanhanxoa', '<?php echo $item->MaCN; ?>', event)">Xóa</button>
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


<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?p=thongtincanhan&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="?p=thongtincanhan&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?p=thongtincanhan&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>


<script>

    function handleActionChange(action, id, event) {
    event.preventDefault(); // Ngăn không cho form submit hoặc hành động mặc định diễn ra
    if (action) {
        var baseUrl = "<?php echo $baseUrl; ?>";
        window.location.href = baseUrl + "?p=" + action + "&id=" + id;
    }
    }

</script>