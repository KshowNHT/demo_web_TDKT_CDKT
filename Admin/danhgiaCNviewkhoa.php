<?php  
    include('./danhgiaCN.php');
    $id = ($_GET["id"]);
    $data = new DanhgiaCN();
    $data  =  $data->ldsskhoa($conn,$id);


    if (isset($_GET["message"])) {
        $message = $_GET["message"];
?>
        <span class="badge badge-primary">
            <?php echo $message ?>
        </span>
<?php
    }
?>

<table class="table">
    <thead>
        <tr>
            <th>Họ và Tên</th>
            <th>Tên Khoa</th>
            <th>Số Quyết Đinh</th>
            <th>Đánh Giá</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data as $item)
            {
        ?>
            <tr>
                <td scope="row"><?php echo $item->MaCN; ?></td>
                <td><?php echo $item->MaKhoa;?></td>
                <td><?php echo $item->SoQD;?></td>
                <td><?php echo $item->DanhGia;?></td>
               <?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
               <td><button type="button" class="btn btn-info"><a href='<?php echo "$baseUrl?p=danhgiaCNsua&&id=$item->MaDGCN" ?>'>Sửa Đánh Giá</a> </button></td>
               <?php
               }
               ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>