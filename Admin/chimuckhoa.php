<?php 
    include("../Admin/connectdb.php");
    $sql = "SELECT * FROM khoa";
    $result = mysqli_query($conn, $sql);
?>

<div class="form-group">
    <label for="khoaSelect">Chọn Khoa:</label>
    <select id="khoaSelect" class="form-control" onchange="redirectPage()">
        <option value="">-- Chọn khoa --</option>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?php echo "$baseUrl?p=danhgiaCNkhoa&&id=" . $row['MaKhoa']; ?>">
                <?php echo $row['TenKhoa']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<script>
    function redirectPage() {
        var selectBox = document.getElementById("khoaSelect");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue) {
            window.location.href = selectedValue;
        }
    }
</script>
