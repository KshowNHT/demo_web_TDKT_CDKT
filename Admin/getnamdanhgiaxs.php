<?php
include('./connectdb.php');

if (isset($_GET['Manam'])) {
    $Manam = $_GET['Manam'];
    // Kiểm tra giá trị của $Manam
    error_log("Manam: " . htmlspecialchars($Manam));

    $sql = "SELECT * FROM danhgiatt WHERE Manam = $Manam";
    
    // Kiểm tra câu truy vấn SQL
    error_log("SQL: " . htmlspecialchars($sql));

    $result = $conn->query($sql);

    $danhgiattList = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $danhgiattList[] = $row;
        }
    }

    // Kiểm tra kết quả truy vấn
    error_log("Kết quả truy vấn: " . print_r($danhgiattList, true));

    echo json_encode($danhgiattList);
} else {
    echo json_encode([]);
}
?>