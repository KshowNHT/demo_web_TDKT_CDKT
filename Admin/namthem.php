<?php
    if(isset($_POST["Nam"])){
        include('./nam.php');
        $data = new Nam();
        $data->Nam = $_POST["Nam"];
        $data->Themnam($conn,$baseUrl);
    }
?>

<form method="post">
   
    <div class="form-group">
        <label for="Nam">Năm:</label>
        <input type="text" class="form-control" id="Nam" name="Nam">
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value="Thêm Năm"/>
    </div>
</form>