<?php
include('./sangkien.php');
$data = sangkien::layDanhSach($conn);


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
$totalRecords = sangkien::layTongSosangkien($conn);

// Tính tổng số trang
$totalPages = ceil($totalRecords / $recordsPerPage);

// Lấy dữ liệu cho trang hiện tại
$data = sangkien::laysangkienPhanTrang($conn, $startFrom, $recordsPerPage);


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

.btn-custom-danger {
    background-color: #d9534f; /* Màu đỏ nhẹ */
}


</style>

<div class="combobox">
    <label for="options">Chọn một tùy chọn:</label>
    <select name="options" id="options" onchange="fetchAndDisplaysangkien(this.value)">
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
            <th>Họ Và Tên </th>
            <th>Đề Tài</th>
            <th>Năm</th>
            <th>Cấp Sáng Kiến</th>
        </tr>
    </thead>
    <tbody id="sangkien-table-body">
        <?php
        foreach ($data as $item) {
        ?>
            <tr class="sangkien-row">
            <td scope="row"><?php echo $item->MaCN !== null ? htmlspecialchars($item->MaCN) : ''; ?></td>
            <td><?php echo $item->TenSK !== null ? htmlspecialchars($item->TenSK) : ''; ?></td>
            <td><?php echo $item->Manam !== null ? htmlspecialchars($item->Manam) : ''; ?></td>
            <td><?php echo $item->CapSK !== null ? htmlspecialchars($item->CapSK) : ''; ?></td>

                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?> 
                    <td>
                        <button class="btn btn-custom btn-custom-primary" onclick="handleAction('sangkienct', '<?php echo $item->MaSK; ?>')">Xem Chi Tiết</button>
                        <button class="btn btn-custom btn-custom-primary" onclick="handleAction('sangkiensua', '<?php echo $item->MaSK; ?>')">Sửa Sáng Kiến</button>
                        <button class="btn btn-custom btn-custom-danger" onclick="handleAction('sangkienxoa', '<?php echo $item->MaSK; ?>')">Xóa Sáng Kiến</button>
                    </td>
                <?php } ?>
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
                <a class="page-link" href="?p=sangkien&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="?p=sangkien&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?p=sangkien&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>


<script>
   async function fetchAndDisplaysangkien(Manam) {
    console.log('Năm đã chọn:', Manam);
    if (Manam === '') {
        window.location.reload();
        return;
    }

    try {
        const response = await fetch(`getsangkien.php?Manam=${Manam}`);
        if (!response.ok) {
            throw new Error('Mạng lỗi');
        }
        const data = await response.json();
        console.log('Năm đã chọn:', data);
        const tableBody = document.getElementById('sangkien-table-body');
        tableBody.innerHTML = '';

        data.forEach(item => {
            console.log('Phản hồi từ server:', item);

            const tr = document.createElement('tr');

            const tdTenKhoa = document.createElement('td');
            tdTenKhoa.textContent = item.HoTen;
            tr.appendChild(tdTenKhoa);

            const tdSoQD = document.createElement('td');
            tdSoQD.textContent = item.TenSK || `Cần Thêm Số Quyết Định Cho ${item.MaKhoa}`;
            tr.appendChild(tdSoQD);

            const tdNam = document.createElement('td');
            tdNam.textContent = item.Nam || `Cần Thêm Năm Cho ${item.Nam}`;
            tr.appendChild(tdNam);

            const tdDanhGia = document.createElement('td');
            tdDanhGia.textContent = item.CapSK;
            tr.appendChild(tdDanhGia);

            // Thay thế combobox bằng các nút button
            if ('<?php echo isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị' ? "true" : "false"; ?>' === 'true') {
                const tdAction = document.createElement('td');

                const buttonCT = document.createElement('button');
                buttonCT.className = 'btn btn-custom btn-custom-primary';
                buttonCT.textContent = 'Xem Chi Tiết';
                buttonCT.onclick = () => handleAction('sangkienct', item.MaSK);
                tdAction.appendChild(buttonCT);

                const buttonSua = document.createElement('button');
                buttonSua.className = 'btn btn-custom btn-custom-primary';
                buttonSua.textContent = 'Sửa Sáng Kiến';
                buttonSua.onclick = () => handleAction('sangkiensua', item.MaSK);
                tdAction.appendChild(buttonSua);

                const buttonXoa = document.createElement('button');
                buttonXoa.className = 'btn btn-custom btn-custom-danger';
                buttonXoa.textContent = 'Xóa Sáng Kiến';
                buttonXoa.onclick = () => handleAction('sangkienxoa', item.MaSK);
                tdAction.appendChild(buttonXoa);

                tr.appendChild(tdAction);
            }

            tableBody.appendChild(tr);
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
