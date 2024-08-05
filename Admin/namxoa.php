<?php
    include('./nam.php');
    if(isset($_GET["id"])){
        $id = isset($_GET["id"]);
        $data = new Nam();
        $data->Manam = $_GET["id"];
        $data  =  $data->Xoanam($conn,$baseUrl);
    }
?>