<?php  
    include('./nam.php');
    $data = Nam::layDanhSach($conn);


    if (isset($_GET["message"])) {
        $message = $_GET["message"];
?>
        <span class="badge badge-primary">
            <?php echo $message ?>
        </span>
<?php
    }
?>
<?php if(isset($_SESSION['TenTk']) && $_SESSION['VaiTro'] === 'Quản Trị'){?> 
<a class="btn btn-primary btn-lg" href="<?php echo " $baseUrl?p=Namth"; ?>">Thêm Năm</a>
<?php
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Năm</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data as $item)
            {
        ?>
            <tr>
                <td scope="row"><?php echo $item->Nam ;?></td>
                <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] == 'Quản Trị'){?> 
                <td><a href='<?php echo "$baseUrl?p=Namsua&&id=$item->Manam" ?>'>Sửa</a> | <a href='<?php echo "$baseUrl?p=Namxoa&&id=$item->Manam" ?>'>Xóa</a></td>
                <?php
                    }
                ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>