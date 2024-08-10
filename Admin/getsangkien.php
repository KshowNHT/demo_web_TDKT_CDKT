<?php
include('./connectdb.php');
class sangkien {
    public $MaSK;
    public $MaCN;
    public $HoTen;
    public $Manam;
    public $TenSK;
    public $CapSK;
    public $Nam;
    public $QD;

    public static function layDanhSachsangkienTheonam($conn, $Manam) {
        $sql = "SELECT * FROM sangkien s INNER JOIN nam n ON s.Manam = n.Manam INNER JOIN thongtincanhan t ON s.MaCN = t.MaCN WHERE n.Manam = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $Manam);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $sangkienList = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $sangkien_obj = new sangkien();
                $sangkien_obj->MaSK = $row["MaSK"];
                $sangkien_obj->MaCN = $row["MaCN"];
                $sangkien_obj->HoTen = $row["HoTen"];
                $sangkien_obj->Manam = $row["Manam"];
                $sangkien_obj->TenSK = $row["TenSK"];
                $sangkien_obj->CapSK = $row["CapSK"];
                $sangkien_obj->Nam = $row["Nam"];
                $sangkien_obj->QD = $row["QD"];
    
                $sangkienList[] = $sangkien_obj;
            }
        }
    
        // Kiểm tra kết quả truy vấn
        error_log("Kết quả truy vấn: " . print_r($sangkienList, true));

        echo json_encode($sangkienList);
    }
}

if (isset($_GET['Manam'])) {
     // Đảm bảo rằng bạn đã bao gồm tệp kết nối database
    $Manam = $_GET['Manam'];
    
    // Kiểm tra giá trị của $Manam
    error_log("Manam: " . htmlspecialchars($Manam));

    // Gọi phương thức để lấy danh sách sáng kiến theo năm
    sangkien::layDanhSachsangkienTheonam($conn, $Manam);
} else {
    echo json_encode([]);
}
?>
