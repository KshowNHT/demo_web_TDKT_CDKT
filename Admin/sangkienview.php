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
            <tr class="danhgiattcp-row">
                <td scope="row"><?php echo htmlspecialchars($item->MaCN); ?></td>
                <td><?php echo htmlspecialchars($item->TenSK); ?></td>
                <td><?php echo htmlspecialchars($item->Manam); ?></td>
                <td><?php echo htmlspecialchars($item->CapSK); ?></td>
                <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?> 
                <td>
                    <select name="action" onchange="handleActionChange(this, '<?php echo $item->MaSK; ?>')">
                        <option value="">Chọn hành động</option>
                        <option value="sangkienct">Xem Chi Tiết</option>
                        <option value="sangkiensua">Sửa Sáng Kiến</option>
                        <option value="sangkienxoa">Xóa Đánh Giá</option>
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
   function fetchAndDisplaysangkien(Manam) {
        if (Manam === '') {
            window.location.reload();
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'getsangkien.php?Manam=' + Manam, true); 
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log('dữ liệu: ', xhr.responseText);
                var data = JSON.parse(xhr.responseText);
                var tableBody = document.getElementById('sangkien-table-body'); 
                tableBody.innerHTML = '';

                data.forEach(function (item) {

                    var tr = document.createElement('tr');

                    var tdMaCN = document.createElement('td');
                    tdMaCN.scope = 'row';
                    tdMaCN.textContent = item.MaCN;
                    tr.appendChild(tdMaCN);

                    var tdTenSK = document.createElement('td');
                    tdTenSK.textContent = item.TenSK;
                    tr.appendChild(tdTenSK);

                    var tdManam = document.createElement('td');
                    tdManam.textContent = item.Manam;
                    tr.appendChild(tdManam);

                    var tdCapSK = document.createElement('td');
                    tdCapSK.textContent = item.CapSK;
                    tr.appendChild(tdCapSK);

                    if ('<?php echo isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị' ? "true" : "false"; ?>' === 'true') {
                        var tdAction = document.createElement('td');
                        var select = document.createElement('select');
                        select.name = 'action';
                        select.onchange = function() { handleActionChange(this, item.MaSK) };

                        var optionDefault = document.createElement('option');
                        optionDefault.value = '';
                        optionDefault.textContent = 'Chọn hành động';
                        select.appendChild(optionDefault);

                        var optionDanhGia = document.createElement('option');
                        optionDanhGia.value = 'sangkienct';
                        optionDanhGia.textContent = 'Xem Chi Tiết';
                        select.appendChild(optionDanhGia);

                        var optionSua = document.createElement('option');
                        optionSua.value = 'sangkiensua';
                        optionSua.textContent = 'Sửa Sáng Kiến';
                        select.appendChild(optionSua);

                        var optionXoa = document.createElement('option');
                        optionXoa.value = 'sangkienxoa';
                        optionXoa.textContent = 'Xóa Sáng Kiến';
                        select.appendChild(optionXoa);

                        tdAction.appendChild(select);
                        tr.appendChild(tdAction);
                    }

                    tableBody.appendChild(tr);
                });
            }
        };
        xhr.send();
    }

    function handleActionChange(select, id) {
        var selectedAction = select.value;
        if (selectedAction) {
            var baseUrl = "<?php echo $baseUrl; ?>";
            window.location.href = baseUrl + "?p=" + selectedAction + "&id=" + id;
        }
    }
</script>
