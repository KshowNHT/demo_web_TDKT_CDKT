<?php
    include('./thongtincanhan.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new thongtincanhan();
        $data->MaCN = $_GET["id"];
        $data  =  $data->Xoathongtincanhan($conn,$baseUrl);
    }
?>