<?php
include('./sangkien.php');
$data = sangkien::layDanhSach($conn);

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
            <th>Sáng Kiến</th>
            <th>Năm</th>
            <th>Cấp Sáng Kiến</th>
        </tr>
    </thead>
    <tbody id="sangkien-table-body">
        <?php
        foreach ($data as $item) {
        ?>
            <tr class="sangkien-row">
                <td scope="row"><?php echo htmlspecialchars($item->MaCN); ?></td>
                <td><?php echo htmlspecialchars($item->TenSK); ?></td>
                <td><?php echo htmlspecialchars($item->nam); ?></td>
                <td><?php echo htmlspecialchars($item->CapSK); ?></td>
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?> 
                <td>
                    <select name="action" onchange="handleActionChange(this, '<?php echo $item->MaSK; ?>')">
                        <option value="">Chọn hành động</option>
                        <option value="sangkienct">Xem Chi Tiết</option>
                        <option value="sangkiensua">Sửa Sáng Kiến</option>
                        <option value="sangkienxoa">Xóa Sáng Kiến</option>
                    </select>
                </td>
                <?php } ?>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

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

                if ('<?php echo isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị' ? "true" : "false"; ?>' === 'true') {
                    const tdAction = document.createElement('td');
                    const select = document.createElement('select');
                    select.name = 'action';
                    select.onchange = () => handleActionChange(select, item.MaDGTT);

                    const optionDefault = document.createElement('option');
                    optionDefault.value = '';
                    optionDefault.textContent = 'Chọn hành động';
                    select.appendChild(optionDefault);

                    const optionct= document.createElement('option');
                    optionct.value = 'sangkienct';
                    optionct.textContent = 'Xem Chi Tiết';
                    select.appendChild(optionct);

                    const optionsua = document.createElement('option');
                    optionsua.value = 'sangkiensua';
                    optionsua.textContent = 'Sửa Sáng Kiến';
                    select.appendChild(optionsua);


                    const optionxoa = document.createElement('option');
                    optionxoa.value = 'sangkienxoa';
                    optionxoa.textContent = 'Xóa Sáng Kiến';
                    select.appendChild(optionxoa);

                    tdAction.appendChild(select);
                    tr.appendChild(tdAction);
                }

                tableBody.appendChild(tr);
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
