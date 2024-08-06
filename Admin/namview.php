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
                <td>
                    <select name="action" onchange="handleActionChange(this, '<?php echo $item->Manam; ?>')">
                        <option value="">Chọn hành động</option>
                        <option value="Namsua">Sửa</option>
                        <option value="Namxoa">Xóa</option>
                    </select>
                </td>
                <?php
                    }
                ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>

<script>

    function handleActionChange(select, id) {
        var selectedAction = select.value;
            if (selectedAction) {
                var baseUrl = "<?php echo $baseUrl; ?>";
                window.location.href = baseUrl + "?p=" + selectedAction + "&id=" + id;
            }
        }
</script>