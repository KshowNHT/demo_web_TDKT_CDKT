<?php
    include('./KTtt.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new ktkyluattt();
        $data->MaKTKLtt = $_GET["id"];
        $data  =  $data->Xoaktkl($conn,$baseUrl);
    }
?>