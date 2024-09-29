<?php
    include('./ktkyluat.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new ktkyluat();
        $data->MaKTKL = $_GET["id"];
        $data  =  $data->Xoaktkl($conn,$baseUrl);
    }
?>