<?php
    ob_start(); // Bắt đầu output buffering

    // Các đoạn mã PHP khác
    if(isset($_GET['p'])) {
        $page = $_GET['p'];
    } else {
        $page = 'trangchinh';
    }
?>
<h4><?php echo $pages[$page][0]?></h4>
<?php
    include($pages[$page][1]);

    ob_end_flush(); // Kết thúc output buffering
?>
