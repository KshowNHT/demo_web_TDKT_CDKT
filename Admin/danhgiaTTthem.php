<?php
    include('./danhgiaTT.php');
    if(isset($_POST["SoQD"])){
        $data = new DanhgiaTT();
        $data->MaKhoa = $_POST["MaKhoa"];  // This should be an array for multiple selections
        $data->SoQD = $_POST["SoQD"];
        $data->Manam = $_POST["Lnam"];
        $data->DanhGia = $_POST["DanhGia"];
        $data->Themdanhgiatt($conn,$baseUrl);
    }

    $Lnam = Nam::layDanhSach($conn);
    $datakhoa = Khoa::layDanhSach($conn);
?>

<div class="container">
    <form method="post">

        <div class="form-group">
            <label for="SoQD">Số Quyết Định:</label>
            <input type="text" class="form-control" id="SoQD" name="SoQD">
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
            <label for="DanhGia">Đánh Giá</label>
            <select class="form-control" name="DanhGia" id="DanhGia">
                <option value="1">Đang Đánh Giá</option>
                <option value="Hoàn Thành Xuất">Hoàn Thành Xuất</option>
                <option value="Hoàn Thành Tốt Nhiệm Vụ">Hoàn Thành Tốt Nhiệm Vụ</option>
                <option value="Hoàn Thành Nhiệm Vụ">Hoàn Thành Nhiệm Vụ</option>
                <option value="Không Hoàn Thành Nhiệm Vụ">Không Hoàn Thành Nhiệm Vụ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Chọn Khoa</label>
            <div class="form-check" id="khoa-list">
            <h5 style="color: Red; margin-top: 20px;">Vui Lòng Chọn Năm Để Đánh Giá Các Khoa</h5>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Cập Nhật Đánh Giá">
        </div>
    </form>
</div>


<script>
$(document).ready(function(){
    $('#Lnam').change(function(){
        var year = $(this).val();
        $.ajax({
            url: 'getmakhoa.php',  // Hãy chắc chắn rằng tên tệp tin này là đúng
            type: 'POST',
            data: {year: year},
            success: function(data) {
                $('#khoa-list').html(data);
            }
        });
    });
});
</script>