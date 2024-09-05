<?php
    include('./nam.php');
    if(isset($_POST["Manam"])){
        $data = new Nam();
        $data->Manam = $_POST["Manam"];
        $data->Nam = $_POST["Nam"];
        $data->Suanam($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new Nam();
        $data  =  $data->laynam($conn,$id);
    }
?>

<form method="post">
    <div class="form-group">
        <label for="Manam">Mã Năm: </label>
        <input type="text" class="form-control" id="Manam" name="Manam" value ='<?php echo $data->Manam ;?>'readonly>
    </div>
    <div class="form-group">
        <label for="Nam">Năm: </label>
        <input type="text" class="form-control" id="Nam" name="Nam" value ='<?php echo $data->Nam ;?>'>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control" value="Sửa Năm"/>
    </div>
</form>