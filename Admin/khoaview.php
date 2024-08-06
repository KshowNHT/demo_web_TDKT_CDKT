<?php  
include('./Khoa.php');
$data = Khoa::layDanhSach($conn);


// Lấy danh sách khoa cho combobox

if (!$data) {
    $data = []; 
}

$MaKhoa = isset($_GET['MaKhoa']) ? $_GET['MaKhoa'] : null;
$options = $data;
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
    <a class="btn btn-primary btn-lg" href="<?php echo " $baseUrl?p=Khoath"; ?>">Thêm Khoa</a>
<?php
}
?>

<div class="combobox">
    <label for="options">Chọn một tùy chọn:</label>
    <select name="options" id="options" onchange="fetchAndDisplayKhoa(this.value)">
        <option value="">Chọn khoa</option>
        <?php foreach($options as $option): ?>
            <option value="<?= htmlspecialchars($option->MaKhoa); ?>"><?= htmlspecialchars($option->TenKhoa); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div id="result">
    <p id="result-text"></p>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên Khoa</th>
            <th>Mô Tả</th>
            <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị'){?> 
                <th>Hành Động</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody id="khoa-table-body">
        <?php foreach($data as $item) { ?>
            <tr>
                <td scope="row"><?php echo $item->TenKhoa ;?></td>
                <td><?php echo $item->MoTa;?></td>
                <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị'){?> 
                <td>
                    <select name="action" onchange="handleActionChange(this, '<?php echo $item->MaKhoa; ?>')">
                        <option value="">Chọn hành động</option>
                        <option value="danhgiaTTth">Cập Nhật Đánh Giá</option>
                        <option value="Khoasua">Sửa</option>
                        <option value="Khoaxoa">Xóa</option>
                    </select>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function fetchAndDisplayKhoa(maKhoa) {
        if (maKhoa === '') {
            window.location.reload();
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'Khoa.php?MaKhoa=' + maKhoa, true); 
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                var tableBody = document.getElementById('khoa-table-body'); 
                tableBody.innerHTML = '';

                data.forEach(function (item) {
                    var tr = document.createElement('tr');

                    var tdTenKhoa = document.createElement('td');
                    tdTenKhoa.scope = 'row';
                    tdTenKhoa.textContent = item.TenKhoa;
                    tr.appendChild(tdTenKhoa);

                    var tdMoTa = document.createElement('td');
                    tdMoTa.textContent = item.MoTa;
                    tr.appendChild(tdMoTa);

                    if ('<?php echo isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị' ? "true" : "false"; ?>' === 'true') {
                        var tdAction = document.createElement('td');
                        var select = document.createElement('select');
                        select.name = 'action';
                        select.onchange = function() { handleActionChange(this, item.MaKhoa) };

                        var optionDefault = document.createElement('option');
                        optionDefault.value = '';
                        optionDefault.textContent = 'Chọn hành động';
                        select.appendChild(optionDefault);

                        var optionDanhGia = document.createElement('option');
                        optionDanhGia.value = 'danhgiaTTth';
                        optionDanhGia.textContent = 'Cập Nhật Đánh Giá';
                        select.appendChild(optionDanhGia);

                        var optionSua = document.createElement('option');
                        optionSua.value = 'Khoasua';
                        optionSua.textContent = 'Sửa';
                        select.appendChild(optionSua);

                        var optionXoa = document.createElement('option');
                        optionXoa.value = 'Khoaxoa';
                        optionXoa.textContent = 'Xóa';
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
