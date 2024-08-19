<?php
include('../Admin/connectdb.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['TenTk'])) {
    header("Location: ../Admin/dangnhap.php");
    exit();
}

// Truy vấn dữ liệu từ database
$query = "SELECT 
                 (SELECT COUNT(*) FROM danhgiacn) AS total_danhgiacn, 
                 (SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('Hoàn Thành Xuất', 'Hoàn Thành Tốt Nhiệm Vụ', 'Hoàn Thành Nhiệm Vụ', 'Không Hoàn Thành Nhiệm Vụ')) AS total_danhgiatt,
                 (SELECT COUNT(*) FROM danhgiatt WHERE DanhGia IN ('TT_LAO_DONG_TIEN_TIEN', 'TT_LAO_DONG_XS', 'GK_Hieu_Truong', 'BK_UBNDTP', 'BK_TTCP', 'Huan_Chuong_Lao_Dong_Hang_Ba', 'Huan_Chuong_Lao_Dong_Hang_Nhi')) AS total_khenthuong,
                 (SELECT COUNT(*) FROM sangkien) AS total_sangkien,
                 (SELECT COUNT(*) FROM khoa) AS total_khoa";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - <?php echo $_SESSION['VaiTro']; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Điều chỉnh kích thước và căn giữa biểu đồ */
        .chart-container {
            max-width: 300px;
            max-height: 300px;
            margin: 20px auto;
            text-align: center;
        }

        .chart-container canvas {
            width: 100%;
            height: 100%;
        }

        /* Định dạng cho phần chứa biểu đồ */
        #chartWrapper {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
    </style>
</head>

<?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?>
<body>
    <h1>Trang chủ - <?php echo $_SESSION['VaiTro']; ?></h1>
    <div id="chartWrapper">
        <!-- Biểu đồ tổng quát -->
        <div class="chart-container">
            <h3>Tổng quát</h3>
            <canvas id="generalPieChart"></canvas>
        </div>

        <!-- Biểu đồ Đánh giá cá nhân -->
        <div class="chart-container">
            <h3>Đánh giá cá nhân</h3>
            <canvas id="danhgiacnChart"></canvas>
        </div>

        <!-- Biểu đồ Đánh giá tập thể -->
        <div class="chart-container">
            <h3>Đánh giá tập thể</h3>
            <canvas id="danhgiattChart"></canvas>
        </div>

        <!-- Biểu đồ Sáng kiến -->
        <div class="chart-container">
            <h3>Sáng kiến</h3>
            <canvas id="sangkienChart"></canvas>
        </div>

        <!-- Biểu đồ Khen thưởng -->
        <div class="chart-container">
            <h3>Khen Thưởng Tập Thể</h3>
            <canvas id="khenthuongttChart"></canvas>
        </div>

        <!-- Biểu đồ Khoa -->
        <div class="chart-container">
            <h3>Khoa</h3>
            <canvas id="khoaChart"></canvas>
        </div>
    </div>

    <script>
        // Dữ liệu tổng quát
        const generalData = [
            <?php echo $data['total_danhgiacn']; ?>, 
            <?php echo $data['total_danhgiatt']; ?>, 
            <?php echo $data['total_khenthuong']; ?>,
            <?php echo $data['total_sangkien']; ?>, 
            <?php echo $data['total_khoa']; ?>
        ];

        // Tạo biểu đồ tổng quát
        new Chart(document.getElementById('generalPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Đánh giá cá nhân', 'Đánh giá tập thể', 'Khen Thưởng Tập Thể', 'Sáng kiến', 'Khoa'],
                datasets: [{
                    label: 'Tổng quát dữ liệu',
                    data: generalData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(255, 99, 132, 0.9)',
                        'rgba(54, 162, 235, 0.9)',
                        'rgba(255, 159, 64, 0.9)',
                        'rgba(255, 206, 86, 0.9)',
                        'rgba(75, 192, 192, 0.9)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // Tạo các biểu đồ riêng biệt
        function createChart(ctx, label, value, backgroundColor, hoverColor) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [label],
                    datasets: [{
                        label: label,
                        data: [value, generalData.reduce((a, b) => a + b) - value], // Tổng trừ đi giá trị riêng lẻ để tạo biểu đồ hình tròn
                        backgroundColor: [backgroundColor, 'rgba(200, 200, 200, 0.3)'],
                        hoverBackgroundColor: [hoverColor, 'rgba(200, 200, 200, 0.5)'],
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                    cutout: '70%' // Làm rỗng giữa để làm rõ ràng hơn
                }
            });
        }

        // Tạo biểu đồ riêng cho từng loại
        createChart(document.getElementById('danhgiacnChart').getContext('2d'), 'Đánh giá cá nhân', <?php echo $data['total_danhgiacn']; ?>, 'rgba(255, 99, 132, 0.7)', 'rgba(255, 99, 132, 0.9)');
        createChart(document.getElementById('khenthuongttChart').getContext('2d'), 'Khen Thưởng Tập Thể', <?php echo $data['total_khenthuong']; ?>, 'rgba(255, 99, 132, 0.7)', 'rgba(255, 99, 132, 0.9)');
        createChart(document.getElementById('danhgiattChart').getContext('2d'), 'Đánh giá tập thể', <?php echo $data['total_danhgiatt']; ?>, 'rgba(54, 162, 235, 0.7)', 'rgba(54, 162, 235, 0.9)');
        createChart(document.getElementById('sangkienChart').getContext('2d'), 'Sáng kiến', <?php echo $data['total_sangkien']; ?>, 'rgba(255, 159, 64, 0.7)', 'rgba(255, 159, 64, 0.9)');
        createChart(document.getElementById('khoaChart').getContext('2d'), 'Khoa', <?php echo $data['total_khoa']; ?>, 'rgba(75, 192, 192, 0.7)', 'rgba(75, 192, 192, 0.9)');
    </script>
</body>
<?php } else { ?>
    <h1>Trang chủ</h1>
<?php } ?>
</html>
