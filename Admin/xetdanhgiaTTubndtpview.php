<?php
include('./danhgiaTT.php');
$data = DanhgiaTT::laydanhsachdanhgiaubndtp($conn);

// Mảng ánh xạ
$awardMap = array(
    'BK_UBNDTP' => 'Bằng Khen Ủy Ban Nhân Dân Thành Phố',
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
    <tbody id="danhgiatp-table-body">
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
                        <option value="danhgiaTTttcpthem">Xét Đánh Giá</option>
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

<script>
   async function fetchAndDisplayDanhGia(Manam) {
    console.log('Năm đã chọn:', Manam);
    if (Manam === '') {
        window.location.reload();
        return;
    }

    try {
        const response = await fetch(`getnamdanhgia.php?Manam=${Manam}`);
        if (!response.ok) {
            throw new Error('Mạng lỗi');
        }
        const data = await response.json();
        const tableBody = document.getElementById('danhgiatp-table-body');
        tableBody.innerHTML = '';

        data.forEach(item => {
            console.log('Phản hồi từ server:', item);

            const validDanhGia = ['BK_UBNDTP'];
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

                const tdDanhGia = document.createElement('td');
                tdDanhGia.textContent = item.DanhGia;
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

                    
                    const optionXet = document.createElement('option');
                    optionXet.value = 'danhgiaTTttcpthem';
                    optionXet.textContent = 'Xét Đánh Giá';
                    select.appendChild(optionXet);

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