<?php  
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    include('./danhgiaCN.php');
    $data = DanhgiaCN::layDanhSach($conn);


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
    $totalRecords = DanhgiaCN::layTongSoDanhGia($conn);

    // Tính tổng số trang
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Lấy dữ liệu cho trang hiện tại
    $data = DanhgiaCN::layDanhGiaPhanTrang($conn, $startFrom, $recordsPerPage);


    if (!$data) {
        $data = []; 
    }
    
    $Manam = isset($_GET['Manam']) ? $_GET['Manam'] : null;
    $options = Nam::layDanhSach($conn);
    if (!$options) {
        $options = [];
    }

    if (isset($_GET["message"])) {
        $message = $_GET["message"];
?>
        <span class="badge badge-primary">
            <?php echo $message ?>
        </span>
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

.btn-custom {
    background-color: #6fc3d0; /* Màu nền xanh nhạt */
    border: none; /* Loại bỏ viền */
    color: white; /* Màu chữ trắng */
    padding: 9px 10px; /* Đệm trong nút (giảm kích thước) */
    font-size: 12px; /* Cỡ chữ nhỏ hơn */
    margin: 2px; /* Khoảng cách giữa các nút */
    cursor: pointer; /* Đổi con trỏ khi hover */
    border-radius: 4px; /* Bo tròn góc nhẹ */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển màu và phóng to khi hover */
}

.btn-custom:hover {
    background-color: #5a9eac; /* Màu nền khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}

.btn-custom-primary {
    background-color: #6fc3d0; /* Màu xanh nhạt */
}

</style>
<?php
include('../Admin/chimuckhoa.php');
?>



<div class="combobox">
    <label for="options">Chọn một tùy chọn:</label>
    <select name="options" id="options" onchange="fetchAndDisplayDanhGia(this.value)">
        <option value="">Chọn Năm</option>
        <?php foreach($options as $option): ?>
            <option value="<?= htmlspecialchars($option->Manam);?>"><?= htmlspecialchars($option->Nam);?></option>
        <?php endforeach;?>
    </select>
</div>
<div id="result">
    <p id="result-text"></p>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Họ và Tên</th>
            <th>Tên Khoa</th>
            <th>Năm</th>
            <th>Số Quyết Đinh</th>
            <th>Đánh Giá</th>
            <th>Ngày</th>
            <th>Đơn Vị</th>
            <th>File PDF</th>
        </tr>
    </thead>
    <tbody id="danhgia-table-body">
        <?php
            foreach($data as $item)
            {
        ?>
            <tr>
                <td scope="row"><?php echo $item->MaCN ?? "Cập Nhật Họ Và Tên"; ?></td>
                <td><?php echo $item->MaKhoa ?? "Cập Nhật Khoa";?></td>
                <td><?php echo htmlspecialchars($item->Manam ?? "Cần Thêm Năm Cho $item->MaKhoa"); ?></td>
                <td><?php echo $item->SoQD;?></td>
                <td><?php echo $item->DanhGia;?></td>
                <td><?php echo date_format(date_create($item->Ngay), "d/m/Y");?></td> 
                <td><?php echo htmlspecialchars($item->DonVi); ?></td>
                <td>
                <?php if ($item->FilePDF): ?>
                    <a href="./<?php echo htmlspecialchars($item->FilePDF); ?>" target="_blank">
                        Tải về / Xem PDF
                    </a>
                <?php else: ?>
                    Chưa có file
                <?php endif; ?>
            </td>
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
                <td>
                <button class="btn btn-custom btn-custom-primary" onclick="handleAction('danhgiaCNsua', '<?php echo $item->MaDGCN; ?>')">Sửa Đánh Giá</button>
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
                <a class="page-link" href="?p=danhgiaCN&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="?p=danhgiaCN&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?p=danhgiaCN&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<script>

async function fetchAndDisplayDanhGia(Manam) {
    console.log('Năm đã chọn:', Manam);
    if (Manam === '') {
        window.location.reload();
        return;
    }

    try {
        const response = await fetch(`getdanhgiacn.php?Manam=${Manam}`);
        if (!response.ok) {
            throw new Error('Mạng lỗi');
        }
        const data = await response.json();
        const tableBody = document.getElementById('danhgia-table-body');
        tableBody.innerHTML = '';

        data.forEach(item => {
            console.log('Phản hồi từ server:', item);

            // Chỉ hiển thị những mục có giá trị DanhGia nằm trong danh sách mong muốn
            const validDanhGia = ['Hoàn Thành Xuất Sắc', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ', 'Chưa Đánh Giá'];
            if (validDanhGia.includes(item.DanhGia)) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.HoTen}</td>
					<td>${item.TenKhoa}</td>
					<td>${item.Nam || `Cần Thêm Năm Cho ${item.MaKhoa}`}</td>
                    <td>${item.SoQD || `Cần Thêm Số Quyết Định Cho ${item.MaKhoa}`}</td>
                    <td>${item.DanhGia}</td>
                    <td>${new Date(item.Ngay).toLocaleDateString('vi-VN')}</td>
                    <td>${item.DonVi}</td>
                    <td>${item.FilePDF ? `<a href='./${item.FilePDF}' target='_blank'>Tải về / Xem PDF</a>` : 'Chưa có file'}</td>
                `;
                tableBody.appendChild(tr);

                if ('<?php echo isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị' ? "true" : "false"; ?>' === 'true') {
                    const tdAction = document.createElement('td');

                    const buttonSua = document.createElement('button');
                    buttonSua.className = 'btn btn-custom btn-custom-primary';
                    buttonSua.textContent = 'Sửa Đánh Giá';
                    buttonSua.onclick = () => handleAction('danhgiaCNsua', item.MaDGCN);
                    tdAction.appendChild(buttonSua);

                    tr.appendChild(tdAction);
                }

                tableBody.appendChild(tr);
            }
        });
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}



function handleAction(action, id) {
        if (action) {
            var baseUrl = "<?php echo $baseUrl; ?>";
            window.location.href = baseUrl + "?p=" + action + "&id=" + id;
        }
    }
</script>