<?php
    include('./dangki.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new taikhoan();
        $data->MaTk = $_GET["id"];
        $data  =  $data->Xoataikhoan($conn,$baseUrl);
    }
?>