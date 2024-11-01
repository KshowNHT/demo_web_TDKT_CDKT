<?php
    include('./sangkien.php');
    if (isset($_POST["TenSK"])) {
        $data = new sangkien();
        $data->MaCN = $_POST["MaCN"];
        $data->Manam = $_POST["Lnam"];
        $data->TenSK = $_POST["TenSK"];
        $data->QD = $_POST["QD"];
        $data->CapSK = $_POST["CapSK"];
        $data->MaSK = $_POST["MaSK"]; // Đảm bảo bạn có giá trị MaSK để sửa
        $data->Suasangkien($conn, $baseUrl);
    } else {
        $id = $_GET["id"];
        $data = new sangkien();
        $data = $data->laysangkien($conn, $id);
    }
    
    $ttcn = sangkien::laysangkienct($conn, $id);


    $Lnam = Nam::layDanhSach($conn);
    ?>

<form method="post">
            <input type="hidden" name="MaSK" value="<?php echo htmlspecialchars($data->MaSK); ?>"> <!-- Ẩn MaSK để sử dụng khi sửa -->
            <div class="form-group">
                <label for="MaCN">Họ Và Tên: <?php echo $ttcn->MaCN ?></label>
                <input type="hidden" class="form-control" id="MaCN" name="MaCN" value="<?php echo htmlspecialchars($data->MaCN); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="TenSK">Tên Sáng Kiến: </label>
                <input type="text" class="form-control" id="TenSK" name="TenSK" value="<?php echo htmlspecialchars($data->TenSK); ?>">
            </div>

            <div class="form-group">
                <label for="QD">Quyết Định: </label>
                <input type="text" class="form-control" id="QD" name="QD" value="<?php echo htmlspecialchars($data->QD); ?>">
            </div>

            <div class="form-group">
                <label for="Lnam">Năm</label>
                <select name="Lnam" id="Lnam" class="form-control">
                    <?php foreach ($Lnam as $L): ?>
                        <option value="<?php echo $L->Manam; ?>" <?php echo $L->Manam == $data->Manam ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($L->Nam); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="CapSK">Cấp Đề Tài</label>
                <select name="CapSK" id="CapSK" class="form-control">
                    <option value="1" <?php echo $data->CapSK == "1" ? 'selected' : ''; ?>>Cấp Đề Tài</option>
                    <option value="Sáng Kiên Cấp Cơ Sở" <?php echo $data->CapSK == "Sáng Kiên Cấp Cơ Sở" ? 'selected' : ''; ?>>Sáng Kiên Cấp Cơ Sở</option>
                    <option value="Sáng Kiên Cấp Thành Phố" <?php echo $data->CapSK == "Sáng Kiên Cấp Thành Phố" ? 'selected' : ''; ?>>Sáng Kiên Cấp Thành Phố</option>
                    <option value="Sáng Kiên Cấp Quận" <?php echo $data->CapSK == "Sáng Kiên Cấp Quận" ? 'selected' : ''; ?>>Sáng Kiên Cấp Quận</option>
                    <option value="Nghiên Cú Khoa Học" <?php echo $data->CapSK == "Nghiên Cú Khoa Học" ? 'selected' : ''; ?>>Nghiên Cú Khoa Học</option>
                    <option value="Khoa Học Công Nghệ" <?php echo $data->CapSK == "Khoa Học Công Nghệ" ? 'selected' : ''; ?>>Khoa Học Công Nghệ</option>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" class="form-control" value=" Sửa Sáng Kiến"/>
            </div>
</form>
