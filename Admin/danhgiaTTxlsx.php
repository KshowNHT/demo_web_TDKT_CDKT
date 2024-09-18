<?php
include('./connectdb.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;



// Lấy dữ liệu từ bảng `danhgiatt`
$sql = "SELECT * FROM danhgiatt d 
        INNER JOIN nam n ON d.Manam = n.Manam 
        INNER JOIN khoa k ON d.MaKhoa = k.MaKhoa 
        WHERE 1=1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Tạo file Excel mới
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Định nghĩa tiêu đề
    $headers = [ 'Tên Khoa', 'Năm', 'Đánh Giá', 'Số Quyết Định'];
    $sheet->fromArray($headers, NULL, 'A1');

    // Định dạng tiêu đề
    $styleArrayHeader = [
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFFF00', // Màu nền vàng
            ],
        ],
    ];
    $sheet->getStyle('A1:M1')->applyFromArray($styleArrayHeader);

    // Định nghĩa màu nền cho tiêu đề "Khoa Tài chính - Kế toán"
    $sheet->getStyle('A2:M2')->applyFromArray([
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFFF00', // Màu vàng
            ],
        ],
    ]);

    // Thêm dữ liệu vào các dòng tiếp theo
    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
    
        // Xử lý dữ liệu sau khi kiểm tra
        $dataRow = [
            isset($row['TenKhoa']) ? $row['TenKhoa'] : '',   // Tên khoa
            isset($row['Nam']) ? $row['Nam'] : '',           // Năm
            isset($row['DanhGia']) ? $row['DanhGia'] : '',   // Đánh giá
            isset($row['SoQD']) ? $row['SoQD'] : '',         // Số quyết định
        ];
    
        // Đưa dữ liệu vào Excel
        $sheet->fromArray($dataRow, NULL, 'A' . $rowNumber);
        $rowNumber++;
    }
    
    

    // Định dạng cho tất cả các ô (căn giữa, đường viền)
    $sheet->getStyle('A2:M' . ($rowNumber - 1))->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ]);

    // Đặt kích thước cột tự động cho phù hợp với nội dung
    foreach (range('A', 'M') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Lưu file Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save('danhgia_output.xlsx');

    echo "Xuất dữ liệu thành công!";
} else {
    echo "Không có dữ liệu!";
}

$conn->close();
?>
