<?php

    $baseUrl = $_SERVER['PHP_SELF'];
    $pages = array(
        'trangchinh' => array('Trang Chủ', 'trangchinh.php'),
        'dangnhap' => array('Đăng Nhập', 'dangnhap.php'),
        'dangki' => array('Đăng Kí Tài Khoản', 'dangkiview.php'),
        'dangxuat' => array('Đăng Xuất', 'dangxuat.php'),
        // Thông Tin Cá Nhân
        'thongtincanhan' => array('Quản Lý Thông Tin ', 'thongtincanhanview.php'),
        'thongtincanhanth' => array('Thêm Thông Tin', 'thongtincanhanthem.php'),
        'thongtincanhansua' => array('Sửa Thông Tin', 'thongtincanhansua.php'),
        'thongtincanhanxoa' => array('Xóa Thông Tin', 'thongtincanhanxoa.php'),
        //Khoa
        'Khoa' => array('Quản lý Khoa', 'khoaview.php'),
        'Khoath' => array('Thêm Khoa', 'Khoathem.php'),
        'Khoasua' => array('Sửa Khoa', 'Khoasua.php'),
        'Khoaxoa' => array('Xóa Khoa', 'Khoaxoa.php'),
        // Đánh Giá Tập Thể 
        'danhgiaTT' => array('Quản Lý Đánh Giá Tập Thể', 'danhgiaTTview.php'),
        'danhgiaTTth' => array('Thêm Đánh Giá', 'danhgiaTTthem.php'),
        'danhgiaTTsua' => array('Sửa Đánh Giá', 'danhgiaTTsua.php'),
        // Đánh Giá Cá Nhân
        'danhgiaCN' => array('Quản lý Đánh Giá Cá Nhân', 'danhgiaCNview.php'),
        'danhgiaCNsua' => array('Sửa Đánh Giá Cá Nhân', 'danhgiaCNsua.php'),
        'danhgiaCNthem' => array('Đánh Giá Cá Nhân', 'danhgiaCNthem.php'),
        'danhgiaCNkhoa' => array('Đánh Giá Cá Nhân', 'danhgiaCNviewkhoa.php'),
        // // khách hàng
        // 'user' => array('Quản lý khách hàng ', 'qluserview.php'),
        // 'userth' => array('Theme Thông Tin Khách Hàng ', 'qluserthem.php'),
        // 'usersua' => array('Sửa Thông Tin Khách Hàng ', 'qlusersua.php'),
        // 'userxoa' => array('Xóa Thông Tin Khách Hàng  ', 'qluserxoa.php'),
    );
    //connect các trang 
    include('../Admin/connectdb.php');
    //include('../client/theme.php'); 
    include('../Admin/them.php')
?>