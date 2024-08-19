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
<a class="btn btn-primary btn-lg" href="<?php echo " $baseUrl?p=thongtincanhanth"; ?>">Thêm Thông Tin</a>
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
                <td><?php echo $item->MaKhoa ?? "Cần Thêm Khoa Cho $item->HoTen";?></td>
                <td><?php echo $item->ChuVu;?></td>
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?>
                    <td>
                    <select name="action" onchange="handleActionChange(this, '<?php echo $item->MaCN; ?>')">
                        <option value="">Chọn hành động</option>
                        <option value="danhgiaCNthem">Xét Đánh Giá</option>
                        <option value="sangkienth">Thêm Sáng Kiến</option>
                        <option value="thongtincanhansua">Sửa</option>
                        <option value="thongtincanhanxoa">Xóa</option>
                    </select>
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

    function handleActionChange(select, id) {
        var selectedAction = select.value;
            if (selectedAction) {
                var baseUrl = "<?php echo $baseUrl; ?>";
                window.location.href = baseUrl + "?p=" + selectedAction + "&id=" + id;
            }
        }
</script>