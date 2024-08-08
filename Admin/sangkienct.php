<?php
    include('./sangkien.php');
    if(isset($_POST["SoQD"])){
        $data = new sangkien();
        $data->MaCN = $_POST["MaCN"];
        $data->Manam = $_POST["Lnam"];
        $data->TenSK = $_POST["TenSK"];
        $data->QD = $_POST["QD"];
        $data->CapSK = $_POST["CapSK"];
        $data->Themsangkien($conn,$baseUrl);
    }else{
        $id = ($_GET["id"]);
        $data = new sangkien();
        $data  =  $data->laysangkien($conn,$id);
    }

    $data_detail =  sangkien::laysangkienct($conn,$id)
    
?>

<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    }

    .product-detail {
        width: 50%;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-detail h1 {
        margin-bottom: 20px;
    }

    .product-detail p {
        margin-bottom: 10px;
    }

    .product-detail p:last-of-type {
        font-weight: bold;
    }

</style>
<div class="product-detail">
        <h3>Họ Và Tên: <?php echo htmlspecialchars($data_detail->MaCN); ?></h3>
        <p>Tên Sáng Kiến: <?php echo htmlspecialchars($data_detail->TenSK); ?></p>
        <p>Quyết Định: <?php echo htmlspecialchars($data_detail->QD); ?></p>
        <p>Cấp Sáng Kiến: <?php echo htmlspecialchars($data_detail->CapSK); ?></p>
        <p>Năm: <?php echo htmlspecialchars($data_detail->Manam); ?></p>
        <button type="button" class="btn btn-info">
            <a href='<?php echo "$baseUrl?p=sangkiensua&&id=$data_detail->MaSK"; ?>'>Sửa Thông Tin Sáng Kiến</a>
        </button>
</div>

