<?php
    include('./sangkien.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new sangkien();
        $data->MaSK = $_GET["id"];
        $data  =  $data->Xoasangkien($conn,$baseUrl);
    }
?>