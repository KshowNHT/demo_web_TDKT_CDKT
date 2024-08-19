<?php
include('./danhgiaTT.php');
$data = DanhgiaTT::laydanhsachdanhgiahcldhb($conn);


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
$totalRecords = DanhgiaTT::layTongSoDanhGiahangba($conn);

// Tính tổng số trang
$totalPages = ceil($totalRecords / $recordsPerPage);

// Lấy dữ liệu cho trang hiện tại
$data = DanhgiaTT::layDanhGiahangba($conn, $startFrom, $recordsPerPage);

// Mảng ánh xạ
$awardMap = array(
    'Huan_Chuong_Lao_Dong_Hang_Ba' => 'Huân Chương Lao Động Hạng Ba',
);

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

<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
    <a class="btn btn-primary btn-lg" href="<?php echo " $baseUrl?p=danhgiaTThcldhbthem"; ?>">Xét Đánh Giá Tập Thể</a>
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
            <th>Tên Khoa</th>
            <th>Số Quyết Định</th>
            <th>Năm</th>
            <th>Đánh Giá</th>
        </tr>
    </thead>
    <tbody id="danhgiahb-table-body">
        <?php
        foreach ($data as $item) {
            // Lấy giá trị đánh giá từ mảng ánh xạ
            $danhGia = isset($awardMap[$item->DanhGia]) ? $awardMap[$item->DanhGia] : $item->DanhGia;
        ?>
            <tr>
                <td scope="row"><?php echo htmlspecialchars($item->MaKhoa) ; ?></td>
                <td><?php echo htmlspecialchars($item->SoQD ?? "Cần Thêm Số Quyết Đinh Cho $item->MaKhoa");?></td>
                <td><?php echo htmlspecialchars($item->Manam ?? "Cần Thêm Năm Cho $item->MaKhoa"); ?></td>
                <td><?php echo htmlspecialchars($danhGia);?></td> <!-- Hiển thị tên loại khen thưởng -->
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
                <td>
                    <select name="action" onchange="handleActionChange(this, '<?php echo $item->MaDGTT; ?>')">
                        <option value="">Chọn hành động</option>
                        <option value="xetdanhgiaTTsua">Sửa Đánh Giá</option>
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
                <a class="page-link" href="?p=danhgiaTThcldhbview&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="?p=danhgiaTThcldhbview&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?p=danhgiaTThcldhbview&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
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

    const awardMap = <?php echo json_encode($awardMap); ?>;

    try {
        const response = await fetch(`getnamdanhgia.php?Manam=${Manam}`);
        if (!response.ok) {
            throw new Error('Mạng lỗi');
        }
        const data = await response.json();
        const tableBody = document.getElementById('danhgiahb-table-body');
        tableBody.innerHTML = '';

        data.forEach(item => {
            console.log('Phản hồi từ server:', item);

            const validDanhGia = ['Huan_Chuong_Lao_Dong_Hang_Ba' ] ;
            if (validDanhGia.includes(item.DanhGia)) {
                const tr = document.createElement('tr');

                const tdTenKhoa = document.createElement('td');
                tdTenKhoa.textContent = item.TenKhoa;
                tr.appendChild(tdTenKhoa);

                const tdSoQD = document.createElement('td');
                tdSoQD.textContent = item.SoQD || `Cần Thêm Số Quyết Định Cho ${item.MaKhoa}`;
                tr.appendChild(tdSoQD);

                const tdNam = document.createElement('td');
                tdNam.textContent = item.Nam || `Cần Thêm Năm Cho ${item.MaKhoa}`;
                tr.appendChild(tdNam);

                // Kiểm tra xem danhGia có trong mảng ánh xạ không
                const danhGia = awardMap[item.DanhGia] !== undefined ? awardMap[item.DanhGia] : item.DanhGia;
                const tdDanhGia = document.createElement('td');
                tdDanhGia.textContent = danhGia;
                tr.appendChild(tdDanhGia);

                if ('<?php echo isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị' ? "true" : "false"; ?>' === 'true') {
                    const tdAction = document.createElement('td');
                    const select = document.createElement('select');
                    select.name = 'action';
                    select.onchange = () => handleActionChange(select, item.MaDGTT);

                    const optionDefault = document.createElement('option');
                    optionDefault.value = '';
                    optionDefault.textContent = 'Chọn hành động';
                    select.appendChild(optionDefault);

                    const optionSua = document.createElement('option');
                    optionSua.value = 'xetdanhgiaTTsua';
                    optionSua.textContent = 'Sửa Đánh Giá';
                    select.appendChild(optionSua);


                    tdAction.appendChild(select);
                    tr.appendChild(tdAction);
                }

                tableBody.appendChild(tr);
            }
        });
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}




    function handleActionChange(select, id) {
        var selectedAction = select.value;
        if (selectedAction) {
            var baseUrl = "<?php echo $baseUrl; ?>";
            window.location.href = baseUrl + "?p=" + selectedAction + "&id=" + id;
        }
    }
</script>