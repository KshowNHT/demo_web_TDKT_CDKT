<?php
    if(isset($_GET['p']))
    {
        $page = $_GET['p'];
    }else{

        $page = 'trangchinh';
    }
    
?>
  <?php
  // Hiển thị nội dung dựa trên quyền hạn
  
  ?>
<h4><?php echo $pages[$page][0]?></h4>
<hr/>
<?php
    include($pages[$page][1]);
    // switch ($_SESSION['VaiTro']) {
    //     case 'admin':
    //       echo "<p>Nội dung dành cho quản trị viên.</p>";
    //       // Thêm các chức năng quản trị ở đây
    //       break;
    //     case 'lecturer':
    //       echo "<p>Nội dung dành cho giảng viên.</p>";
    //       // Thêm các chức năng cho giảng viên ở đây
    //       break;
    //     case 'department':
    //       echo "<p>Nội dung dành cho khoa.</p>";
    //       // Thêm các chức năng cho khoa ở đây
    //       break;
    //     default:
    //       echo "<p>Bạn không có quyền truy cập.</p>";
    //       break;
    //   }
?>