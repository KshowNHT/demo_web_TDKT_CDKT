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
    }

    $Lnam = Nam::layDanhSach($conn);
    
?>

<form method="post">
<div class="form-group">
        <label for="MaCN">Họ Và Tên: </label>
        <input type="text" class="form-control" id="MaCN" name="MaCN" value ='<?php echo $data->MaCN;?>' readonly>
    </div>


    <div class="form-group">
        <label for="TenSK">Tên Sáng Kiến: </label>
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
        <label >Đánh Giá</label>
        <select name="CapSK" id="CapSK">
            <option value="1">Cấp Sáng Kiến</option>
            <option value="Cấp Cơ Sở" >Cấp Cơ Sở</option>
            <option value="Cấp Thành Phố" >Cấp Thành Phố</option>
            <option value="Cấp Quận" >Cấp Quận</option>
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