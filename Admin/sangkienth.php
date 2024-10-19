<?php
    include('./sangkien.php');
    if(isset($_POST["TenSK"])){
        $data = new sangkien();
        $data->MaCN = $_POST["MaCN"];
        $data->Manam = $_POST["Lnam"];
        $data->TenSK = $_POST["TenSK"];
        $data->QD = $_POST["QD"];
        $data->CapSK = $_POST["CapSK"];
        $data->Themsangkien($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new thongtincanhan();
        $data  =  $data->laythongtincanhan($conn,$id); 
        $ten = $data->HoTen;
    }

    $Lnam = Nam::layDanhSach($conn);
    
?>

<form method="post">
    <div class="form-group">
        <label for="MaCN">Họ Và Tên: <?php echo $ten?></label>
        <input type="hidden" class="form-control" id="MaCN" name="MaCN" value="<?php echo htmlspecialchars($data->MaCN); ?>" readonly>
    </div>


    <div class="form-group">
        <label for="TenSK">Đề tài: </label>
        <input type="text" class="form-control" id="TenSK" name="TenSK">
    </div>

    <div class="form-group">
        <label for="QD">Quyết Định: </label>
        <input type="text" class="form-control" id="QD" name="QD">
    </div>

    <div>
        <label >Năm</label>
        <select  name="Lnam" id="Lnam" >
        <?php
        foreach($Lnam as $L ){
        ?>
        <option value="<?php echo $L->Manam ;?>"><?php echo $L->Nam ;?></option>

       <?php
        }
       ?>
     </select>
    </div>

    <div class="form-group">
        <label >Cấp Đề Tài</label>
        <select name="CapSK" id="CapSK">
            <option value="1">Không Có Cấp</option>
            <option value="Sáng Kiên Cấp Cơ Sở" >Sáng Kiên Cấp Cơ Sở</option>
            <option value="Sáng Kiên Cấp Thành Phố" >Sáng Kiên Cấp Thành Phố</option>
            <option value="Sáng Kiên Cấp Quận" >Sáng Kiên Cấp Quận</option>
            <option value="Nghiên Cú Khoa Học" >Nghiên Cú Khoa Học</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value=" Thêm Sáng Kiến"/>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var maCNInput = document.getElementById('MaCN');
        var displayValue = maCNInput.getAttribute('data-display-value');
    });
</script>