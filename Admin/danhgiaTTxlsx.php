<?php
include('./connectdb.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Lấy dữ liệu từ bảng `danhgiatt`
$sql = "SELECT * FROM danhgiatt d 
        INNER JOIN nam n ON d.Manam = n.Manam 
        INNER JOIN khoa k ON d.MaKhoa = k.MaKhoa 
        WHERE d.DanhGia IN ('Tập Thể Lao Động Tiên Tiến', 'Tập Thể Lao Động Xuất Sắc', 'Giấy Khen Hiệu Trưởng', 'Bằng Khen Ủy Ban Nhân Dân Thành Phố', 'Bằng Khen Thủ Tướng Chính Phủ', 'Huân Chương Lao Động Hạng Ba', 'Huân Chương Lao Động Hạng Nhì')";
$result = $conn->query($sql);

// Khởi tạo các loại đánh giá có thể có
$evaluationTypes = [
    'Tập Thể Lao Động Tiên Tiến',
    'Tập Thể Lao Động Xuất Sắc',
    'Giấy Khen Hiệu Trưởng',
    'Bằng Khen Ủy Ban Nhân Dân Thành Phố',
    'Bằng Khen Thủ Tướng Chính Phủ',
    'Huân Chương Lao Động Hạng Ba',
    'Huân Chương Lao Động Hạng Nhì'
];

if ($result->num_rows > 0) {
    // Tạo file Excel mới
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Định nghĩa tiêu đề: STT, Đơn Vị, Năm, và các loại đánh giá
    $headers = array_merge(['STT', 'Đơn Vị', 'Năm'], $evaluationTypes);
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

    // Áp dụng định dạng cho tiêu đề
    $sheet->getStyle('A1:' . chr(65 + count($headers) - 1) . '1')->applyFromArray($styleArrayHeader);

    // Thêm dữ liệu vào các dòng tiếp theo
    $rowNumber = 2;
    $index = 1;  // Biến đếm cho Số thứ tự
    while ($row = $result->fetch_assoc()) {
        // Xử lý dữ liệu
        $dataRow = [
            $index,  // Số thứ tự
            isset($row['TenKhoa']) ? $row['TenKhoa'] : '',   // Tên khoa
            isset($row['Nam']) ? $row['Nam'] : '',           // Năm
        ];

        // Kiểm tra và đánh dấu 'X' cho từng loại đánh giá
        foreach ($evaluationTypes as $type) {
            $dataRow[] = ($row['DanhGia'] === $type) ? 'X' : '';
        }

        // Đưa dữ liệu vào Excel
        $sheet->fromArray($dataRow, NULL, 'A' . $rowNumber);
        $rowNumber++;
        $index++;  // Tăng số thứ tự
    }

    // Định dạng cho tất cả các ô (căn giữa, đường viền)
    $sheet->getStyle('A2:' . chr(65 + count($headers) - 1) . ($rowNumber - 1))->applyFromArray([
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
    foreach (range('A', chr(65 + count($headers) - 1)) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Lưu file Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save('KhenThuong_output.xlsx');

    echo "Xuất dữ liệu thành công!";
} else {
    echo "Không có dữ liệu!";
}

$conn->close();
?>
<a href="./KhenThuong_output.xlsx">Tải xuống</a>