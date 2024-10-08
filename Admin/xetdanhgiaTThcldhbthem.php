<?php
include('./danhgiaTT.php');

if (isset($_POST["SoQD"])) {
    $data = new DanhgiaTT();
    $data->MaKhoa = $_POST["MaKhoa"];
    $data->SoQD = $_POST["SoQD"];
    $data->Manam = $_POST["Lnam"];
    $data->Ngay = $_POST["Ngay"];
    $data->DonVi = $_POST["Ldonvi"];

    $criteriaData = [
        'duoc_tang_bang_khen_ttcp' => isset($_POST['duoc_tang_bang_khen_ttcp']),
        'co_5_nam_hoan_thanh_xsnv' => isset($_POST['co_5_nam_hoan_thanh_xsnv']),
        'dat_danh_hieu_ttldxs' => isset($_POST['dat_danh_hieu_ttldxs']),
        'co_1_lan_duoc_tang_co_thi_dua_cp' => isset($_POST['co_1_lan_duoc_tang_co_thi_dua_cp']),
        'co_2_lan_duoc_tang_co_thi_dua_ubnd' => isset($_POST['co_2_lan_duoc_tang_co_thi_dua_ubnd']),
        'co_1_lan_duoc_tang_co_thi_dua_ubnd' => isset($_POST['co_1_lan_duoc_tang_co_thi_dua_ubnd']),
        'co_1_lan_duoc_tang_bang_khen' => isset($_POST['co_1_lan_duoc_tang_bang_khen']),
        'dong_y' => isset($_POST['dong_y'])
    ];

    $data->Themxetdanhgiahcldhb($conn, $baseUrl, $criteriaData);
}

$Lnam = Nam::layDanhSach($conn);
$datakhoa = Khoa::layDanhSach($conn);
?>

<style>
  .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group.row.flex-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .form-group.row.flex-container .col {
        flex: 1;
    }
    .form-control {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group input[type="checkbox"] {
        margin-right: 10px;
    }

    .form-group.flex-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-group.flex-container label {
        flex-basis: 48%;
        display: flex;
        align-items: center;
    }

    .form-check {
        display: flex;
        flex-direction: column;
    }

    .form-check label {
        margin-bottom: 10px;
    }

    .form-control[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .form-control[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<div class="container">
    <h2>Đánh Giá Thành Tích</h2>
    <form method="post">
        
        <div class="form-group">
            <label for="Lnam">Năm:</label>
            <select class="form-control" name="Lnam" id="Lnam" required>
                <option value="">Chọn Năm</option>
                <?php foreach($Lnam as $L) { ?>
                    <option value="<?php echo $L->Manam; ?>"><?php echo $L->Nam; ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group row flex-container">
            <div class="col">
                <label for="SoQD">Số Quyết Định:</label>
                <input type="text" class="form-control" id="SoQD" name="SoQD">
            </div>
            <div class="col">
                <label for="Ngay">Ngày:</label>
                <input type="date" class="form-control" id="Ngay" name="Ngay">
            </div>
            <div class="col">
                <label for="Ldonvi">Đơn Vị:</label>
                <select class="form-control" name="Ldonvi" id="Ldonvi">
                    <option value="">Chọn Đơn Vị</option>
                    <?php foreach($datakhoa as $L) { ?>
                        <option value="<?php echo $L->TenKhoa; ?>"><?php echo $L->TenKhoa; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group flex-container">
            <label><input type="checkbox" id="duoc_tang_bang_khen_ttcp" name="duoc_tang_bang_khen_ttcp"> Đã được tặng “Bằng khen của TTCP”</label>
            <label><input type="checkbox" id="co_5_nam_hoan_thanh_xsnv" name="co_5_nam_hoan_thanh_xsnv"> Có liên tục từ 05 năm trở lên hoàn thành XSNV</label>
            <label><input type="checkbox" id="dat_danh_hieu_ttldxs" name="dat_danh_hieu_ttldxs"> Đạt danh hiệu TTLĐXS</label>
            <label><input type="checkbox" id="co_1_lan_duoc_tang_co_thi_dua_cp" name="co_1_lan_duoc_tang_co_thi_dua_cp"> Có 01 lần được tặng “Cờ thi đua của Chính phủ”</label>
            <label><input type="checkbox" id="co_2_lan_duoc_tang_co_thi_dua_ubnd" name="co_2_lan_duoc_tang_co_thi_dua_ubnd"> Có 02 lần được tặng cờ thi đua của UBND</label>
            <label><input type="checkbox" id="co_1_lan_duoc_tang_co_thi_dua_ubnd" name="co_1_lan_duoc_tang_co_thi_dua_ubnd"> Có 01 lần được tặng cờ thi đua của UBND</label>
            <label><input type="checkbox" id="co_1_lan_duoc_tang_bang_khen" name="co_1_lan_duoc_tang_bang_khen"> 01 lần được tặng bằng khen của UBND</label>
            <label><input type="checkbox" id="dong_y" name="dong_y"> Có 2/3 thành viên HĐ đồng ý</label>
        </div>

        <div class="form-group form-check">
            <label>Chọn Khoa:</label>
            <div id="khoa-list">
                <h5>Vui Lòng Chọn Năm Để Đánh Giá Các Khoa</h5>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="form-control" value="Cập Nhật Đánh Giá">
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#Lnam').change(function(){

            var year = $(this).val();
            $.ajax({
                url: 'getkhoatheodanhgiahangba.php',
                type: 'POST',
                data: {year: year},
                success: function(data) {
                    $('#khoa-list').html(data);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const coThiDuaCP = document.getElementById('co_1_lan_duoc_tang_co_thi_dua_cp');
        const coThiDuaUBND2 = document.getElementById('co_2_lan_duoc_tang_co_thi_dua_ubnd');
        const coThiDuaUBND1 = document.getElementById('co_1_lan_duoc_tang_co_thi_dua_ubnd');
        const hoanThanhXSNV = document.getElementById('co_5_nam_hoan_thanh_xsnv');
        const ttlDXS = document.getElementById('dat_danh_hieu_ttldxs');

        coThiDuaCP.addEventListener('change', function () {
            if (coThiDuaCP.checked) {
                coThiDuaUBND2.checked = false;
                coThiDuaUBND2.disabled = true;
                coThiDuaUBND1.checked = false;
                coThiDuaUBND1.disabled = true;
            } else {
                coThiDuaUBND2.disabled = false;
                coThiDuaUBND1.disabled = false;
            }
        });

        coThiDuaUBND2.addEventListener('change', function () {
            if (coThiDuaUBND2.checked) {
                coThiDuaCP.checked = false;
                coThiDuaCP.disabled = true;
                coThiDuaUBND1.checked = false;
                coThiDuaUBND1.disabled = true;
            } else {
                coThiDuaCP.disabled = false;
                coThiDuaUBND1.disabled = false;
            }
        });

        coThiDuaUBND1.addEventListener('change', function () {
            if (coThiDuaUBND1.checked) {
                coThiDuaCP.checked = false;
                coThiDuaCP.disabled = true;
                coThiDuaUBND2.checked = false;
                coThiDuaUBND2.disabled = true;
            } else {
                coThiDuaCP.disabled = false;
                coThiDuaUBND2.disabled = false;
            }
        });

        hoanThanhXSNV.addEventListener('change', function () {
            if (hoanThanhXSNV.checked) {
                ttlDXS.checked = false;
                ttlDXS.disabled = true;
            } else {
                ttlDXS.disabled = false;
            }
        });

        ttlDXS.addEventListener('change', function () {
            if (ttlDXS.checked) {
                hoanThanhXSNV.checked = false;
                hoanThanhXSNV.disabled = true;
            } else {
                hoanThanhXSNV.disabled = false;
            }
        });
    });
</script>
