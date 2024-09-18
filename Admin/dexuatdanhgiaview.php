<?php
include('./danhgiaTT.php');
$data = DanhgiaTT::laydexuatdanhgia($conn);
$awardMap = array(
    'Tập Thể Lao Động Tiên Tiến'=>'Tập Thể Lao Động Tiên Tiến',
    'Tập Thể Lao Động Xuất Sắc'=>'Tập Thể Lao Động Xuất Sắc',
    'Giấy Khen Hiệu Trưởng'=>'Giấy Khen Hiệu Trưởng',
    'Bằng Khen UBND Thành Phố'=>'Bằng Khen UBND Thành Phố',
    'Bằng Khen Thủ Tướng Chính Phủ'=>'Bằng Khen Thủ Tướng Chính Phủ',
    'Huân Chương Lao Động Hạng Ba'=>'Huân Chương Lao Động Hạng Ba',
    'Huân Chương Lao Động Hạng Nhì'=>'Huân Chương Lao Động Hạng Nhì'
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
<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Khoa'){?> 
    <a class="btn btn-custom btn-custom-primary" href="<?php echo " $baseUrl?p=dexuatkhenthuong"; ?>">Đề Xuất Khen Thưởng Tập Thể</a>
<?php
}
?>
<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Giảng Viên'){?> 
    <a class="btn btn-custom btn-custom-primary" href="#">Đề Xuất Khen Thưởng Cá Nhân</a>
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

.search-box {
    margin-bottom: 15px;
}

.search-box input {
    padding: 8px;
    margin-right: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.search-box button {
    padding: 8px 12px;
}


</style>

<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
    <a class="btn btn-custom btn-custom-primary" href="<?php echo " $baseUrl?p=danhgiaTThcldhnthem"; ?>">Xét Đánh Giá Tập Thể</a>
<?php
}
?>

<div class="search-box">
    <input type="text" id="searchTenKhoa" placeholder="Nhập Tên Khoa" />
    <button class="btn btn-custom btn-custom-primary" onclick="searchData()">Tìm Kiếm</button>
</div>


<div class="combobox">
    <label for="options">Chọn một tùy chọn:</label>
    <select name="options" id="options" onchange="fetchAndDisplayDanhGia(this.value)">
        <option value="">Chọn Năm</option>
        <?php foreach($options as $option): ?>
            <option value="<?= htmlspecialchars($option->Nam);?>"><?= htmlspecialchars($option->Nam);?></option>
        <?php endforeach;?>
    </select>
</div>
<div id="result">
    <p id="result-text"></p>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Số Thứ Tự</th> <!-- Thêm tiêu đề cho Số Thứ Tự -->
            <th>Tên Khoa</th>
            <th>Năm</th>
            <th>Đánh Giá</th>
            <th>Đề Xuất Khen Thưởng</th>
        </tr>
    </thead>
    <tbody id="danhgiatt-table-body">
        <?php
        $stt = 1; // Khởi tạo biến đếm Số Thứ Tự
        foreach ($data as $item) {
            // Lấy giá trị đánh giá từ mảng ánh xạ
            $danhGia = isset($awardMap[$item->DanhGia]) ? $awardMap[$item->DanhGia] : $item->DanhGia;
            $DeXuatDanhGia = isset($awardMap[$item->DeXuatDanhGia]) ? $awardMap[$item->DeXuatDanhGia] : $item->DeXuatDanhGia;
        ?>
            <tr>
                <td scope="row"><?php echo $stt++; ?></td> <!-- Hiển thị Số Thứ Tự và tăng biến đếm -->
                <td><?php echo htmlspecialchars($item->MaKhoa) ; ?></td>
                <td><?php echo htmlspecialchars($item->Manam ?? "Cần Thêm Năm Cho $item->MaKhoa"); ?></td>
                <td><?php echo htmlspecialchars($danhGia);?></td> 
                <td><?php echo htmlspecialchars($DeXuatDanhGia); ?></td> 
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>



<script>
    const awardMap = {
        'Tập Thể Lao Động Tiên Tiến': 'Tập Thể Lao Động Tiên Tiến',
    'Tập Thể Lao Động Xuất Sắc': 'Tập Thể Lao Động Xuất Sắc',
    'Giấy Khen Hiệu Trưởng': 'Giấy Khen Hiệu Trưởng',
    'Bằng Khen UBND Thành Phố': 'Bằng Khen UBND Thành Phố',
    'Bằng Khen Thủ Tướng Chính Phủ': 'Bằng Khen Thủ Tướng Chính Phủ',
    'Huân Chương Lao Động Hạng Ba': 'Huân Chương Lao Động Hạng Ba',
    'Huân Chương Lao Động Hạng Nhì': 'Huân Chương Lao Động Hạng Nhì'
    };

    // Fetch data based on the selected year
    async function fetchAndDisplayDanhGia(Manam) {
        console.log('Năm đã chọn:', Manam);
        if (Manam === '') {
            window.location.reload();
            return;
        }

        try {
            const response = await fetch(`getmadexuatdanhgia.php?Manam=${Manam}`);
            if (!response.ok) {
                throw new Error('Mạng lỗi');
            }
            const data = await response.json();
            console.log('Dữ liệu từ server:', data);

            const tableBody = document.getElementById('danhgiatt-table-body');
            tableBody.innerHTML = '';  // Clear the table

            let stt = 1;  // Khởi tạo biến số thứ tự

            data.forEach(item => {
                const tr = document.createElement('tr');

                // Thêm ô Số Thứ Tự
                const tdSTT = document.createElement('td');
                tdSTT.textContent = stt++;  // Hiển thị và tăng số thứ tự
                tr.appendChild(tdSTT);

                const tdTenKhoa = document.createElement('td');
                tdTenKhoa.textContent = item.TenKhoa;
                tr.appendChild(tdTenKhoa);

                const tdNam = document.createElement('td');
                tdNam.textContent = item.Nam || `Cần Thêm Năm Cho ${item.TenKhoa}`;
                tr.appendChild(tdNam);

                const tdDanhGia = document.createElement('td');
                tdDanhGia.textContent = awardMap[item.DanhGia] || item.DanhGia;
                tr.appendChild(tdDanhGia);

                const tdDeXuatKhenThuong = document.createElement('td');
                tdDeXuatKhenThuong.textContent = item.DeXuatKhenThuong;
                tr.appendChild(tdDeXuatKhenThuong);

                tableBody.appendChild(tr);
            });
        } catch (error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
        }
    }

    // Function to handle the search
    async function searchData() {
        const searchTenKhoa = document.getElementById('searchTenKhoa').value.trim();
        const selectedManam = document.getElementById('options').value;

        const queryString = `getmadexuatdanhgia.php?TenKhoa=${encodeURIComponent(searchTenKhoa)}&Manam=${encodeURIComponent(selectedManam)}`;

        try {
            const response = await fetch(queryString);
            if (!response.ok) {
                throw new Error('Mạng lỗi');
            }
            const data = await response.json();

            const tableBody = document.getElementById('danhgiatt-table-body');
            tableBody.innerHTML = '';  // Clear table

            let stt = 1;  // Khởi tạo biến số thứ tự

            data.forEach(item => {
                const tr = document.createElement('tr');

                // Thêm ô Số Thứ Tự
                const tdSTT = document.createElement('td');
                tdSTT.textContent = stt++;  // Hiển thị và tăng số thứ tự
                tr.appendChild(tdSTT);

                const tdTenKhoa = document.createElement('td');
                tdTenKhoa.textContent = item.TenKhoa;
                tr.appendChild(tdTenKhoa);

                const tdNam = document.createElement('td');
                tdNam.textContent = item.Nam || `Cần Thêm Năm Cho ${item.TenKhoa}`;
                tr.appendChild(tdNam);

                const tdDanhGia = document.createElement('td');
                tdDanhGia.textContent = awardMap[item.DanhGia] || item.DanhGia;
                tr.appendChild(tdDanhGia);

                const tdDeXuatKhenThuong = document.createElement('td');
                tdDeXuatKhenThuong.textContent = item.DeXuatKhenThuong;
                tr.appendChild(tdDeXuatKhenThuong);

                tableBody.appendChild(tr);
            });
        } catch (error) {
            console.error('Lỗi khi tìm kiếm:', error);
        }
    }
</script>


