<?php
    include('./Khoa.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new Khoa();
        $data->MaKhoa = $_GET["id"];
        $data  =  $data->XoaKhoa($conn,$baseUrl);
    }
?>