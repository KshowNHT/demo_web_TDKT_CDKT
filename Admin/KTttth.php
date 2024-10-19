<?php
    include('./KTtt.php');
    if(isset($_POST["KhenThuong"])){
        $data = new ktkyluattt();
        $data->MaKhoa = $_POST["MaKhoa"];
        $data->KhenThuong = $_POST["KhenThuong"];
        $data->Manam = $_POST["Lnam"];
        $data->SoQuyetDinh = $_POST["SoQuyetDinh"];
        $data->NgayQuyetDinh = $_POST["Ngay"];
        $data->DonVi = $_POST["Ldonvi"];
        $data->GhiChu = $_POST["GhiChu"];

        // Kiểm tra và lấy file PDF từ biến $_FILES
        if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $data->FilePDF = $_FILES['file'];  // Gán file PDF vào thuộc tính FilePDF
        } else {
            $data->FilePDF = null; // Nếu không có file hoặc có lỗi khi upload
        }

        // Thực hiện thêm đánh giá vào database
        $data->Themktkyluattt($conn, $baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new Khoa();
        $data  =  $data->layKhoa($conn,$id); 
        if (isset($data->TenKhoa)) {
            $ten = $data->TenKhoa;
        } else {
            $ten = "Không xác định";
        }
    }
    $Lnam = Nam::layDanhSach($conn);
    $datakhoa = Khoa::layDanhSach($conn);
?>


<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
    color: #343a40;
}

.container {
    max-width: 900px; /* Tăng chiều rộng container */
    margin: 40px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #007bff;
    font-weight: 700;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
    line-height: 1.5;
}

.form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px; /* Bo góc mạnh hơn */
        font-size: 16px;
        height: 40px; /* Đặt chiều cao tối thiểu cho các thẻ select */
        line-height: 1.5; /* Căn chỉnh dòng để đảm bảo nội dung không bị cắt */
        color: #555;
}

.form-group.row {
    display: flex;
    gap: 20px;
}

.form-group.row .col {
    flex: 1;
    min-width: 150px; /* Ensure a minimum width for columns */
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    outline: none;
}
.form-control select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    }

.form-group input[type="checkbox"] {
    margin-right: 12px;
}

.form-check {
    display: flex;
    flex-direction: column;
    margin-bottom: 25px;
}

.form-control[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 18px;
    line-height: 1.5;
    padding: 12px;
    margin-top: 20px;
    text-align: center;
}

.form-control[type="submit"]:hover {
    background-color: gray;
}

#khoa-list h5 {
    color: #dc3545;
    margin-top: 25px;
}



</style>

<div class="container">
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <h2>Đánh Giá Thành Tích</h2>


        <div class="form-group">
            <label for="MaKhoa">Đơn Vị: <?php echo $ten?></label>
            <input type="hidden" class="form-control" id="MaKhoa" name="MaKhoa" value="<?php echo htmlspecialchars($data->MaKhoa); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="Lnam">Năm</label>
            <select class="form-control" name="Lnam" id="Lnam">
                <option value="">Chọn Năm</option>
                <?php foreach($Lnam as $L) { ?>
                    <option value="<?php echo $L->Manam; ?>"><?php echo $L->Nam; ?></option>
                <?php } ?>
            </select>
        </div>

        

        
        <div class="form-group">
            <label for="KhenThuong">Khen Thưởng</label>
            <select class="form-control" name="KhenThuong" id="KhenThuong">
                <option value="1">Đang Khen Thưởng</option>
                <option value="Cờ Thi Đua Ủy Ban Nhân Dân">Cờ Thi Đua Ủy Ban Nhân Dân</option>
                <option value="Cờ Thi Đua Chính Phủ">Cờ Thi Đua Chính Phủ</option>
            </select>
        </div>

        <div class="form-group row">

            <div class="col">
                <label for="SoQuyetDinh">Số Quyết Định:</label>
                <input type="text" class="form-control" id="SoQuyetDinh" name="SoQuyetDinh">
            </div>
            <div class="col">
                <label for="Ngay">Ngày :</label>
                <input type="date" class="form-control" id="Ngay" name="Ngay">
            </div>
            <div class="col-md-4">
                    <div class="form-group">
                        <label for="Ldonvi">Đơn Vị</label>
                        <select class="form-control" name="Ldonvi" id="Ldonvi">
                            <option value="">Đơn Vị</option>
                            <?php foreach($datakhoa as $L) { ?>
                                <option value="<?php echo $L->TenKhoa; ?>"><?php echo $L->TenKhoa; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
        </div>

        <!-- Thêm phần chọn file PDF -->
        <div class="form-group">
            <label for="file">Chọn file PDF:</label>
            <input type="file" name="file" id="file" accept="application/pdf">
        </div>
        <div class="form-group">
            <div class="col">
                <label for="GhiChu">Ghi Chú:</label>
                <input type="text" class="form-control" id="GhiChu" name="GhiChu">
            </div>
        </div>


        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Thêm">
        </div>
    </form>
</div>


<script>
function validateForm() {
    let soQuyetDinh = document.getElementById('SoQuyetDinh').value;
    let ngay = document.getElementById('Ngay').value;
    let lnam = document.getElementById('Lnam').value;
    let ldonvi = document.getElementById('Ldonvi').value;

    if ( soQuyetDinh == "" || ngay == "" || lnam == ""|| ldonvi == "") {
        alert("Vui lòng điền đầy đủ các trường bắt buộc!");
        return false;
    }
    return true;
}
</script>