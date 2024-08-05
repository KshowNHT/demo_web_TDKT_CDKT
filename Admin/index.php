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
        //Năm
        'Nam' => array('Quản lý Năm', 'namview.php'),
        'Namth' => array('Thêm Năm', 'namthem.php'),
        'Namsua' => array('Sửa Năm', 'namsua.php'),
        'Namxoa' => array('Xóa Năm', 'namxoa.php'),
        // Đánh Giá Tập Thể 
        'danhgiaTT' => array('Quản Lý Đánh Giá Tập Thể', 'danhgiaTTview.php'),
        'danhgiaTTth' => array('Thêm Đánh Giá', 'danhgiaTTthem.php'),
        'danhgiaTTsua' => array('Sửa Đánh Giá', 'danhgiaTTsua.php'),
        'xetdanhgiaTT' => array('Đánh Giá Tập Thể', 'xetdanhgiaTT.php'),
        'danhgiaTTtientienview' => array('Đánh Giá Tập Thể Lao Động Tiên Tiến', 'danhgiaTTtientienview.php'),
        'danhgiaTTxsvahieutruong' => array('Đánh Giá Tập Thể', 'xedanhgiaTTxsvahieutruong.php'),
        'danhgiaTTxs' => array('Đánh Giá Tập Thể Lao Động Xuất Sắc', 'danhgiaTTxsview.php'),
        'danhgiaTThieutruong' => array('Đánh Giá Tập Thể GK Hiệu Trưởng', 'danhgiaTThieutruongview.php'),
        'danhgiaTThubndtp' => array('Đánh Giá Tập Thể BK UBNDTP', 'xetdanhgiaTTubndtpview.php'),
        'danhgiaTThubndtpthem' => array('Xét Đánh Giá Tập Thể BK UBNDTP', 'xetdanhgiaTTubndtpthem.php'),
        'xetdanhgiaTTsua' => array('Sửa Đánh Giá', 'xetdanhgiaTTsua.php'),
        'danhgiaTTttcpthem' => array('Xét Đánh Giá Tập Thể BK TTCP', 'xetdanhgiaTTttcpthem.php'),
        'danhgiaTTttcpview' => array('Đánh Giá Tập Thể BK TTCP', 'xetdanhgiaTTttcpview.php'),
        'danhgiaTThcldhbthem' => array('Xét Đánh Giá Tập Thể Huân Chương Lao Động Hạng Ba', 'xetdanhgiaTThcldhbthem.php'),
        'danhgiaTThcldhbview' => array('Đánh Giá Tập Thể Huân Chương Lao Động Hạng Ba', 'xetdanhgiaTThcldhbview.php'),
        'danhgiaTThcldhnthem' => array('Xét Đánh Giá Tập Thể Huân Chương Lao Động Hạng Nhì', 'danhgiaTThcldhnthem.php'),
        'danhgiaTThcldhnview' => array('Đánh Giá Tập Thể Huân Chương Lao Động Hạng Nhì', 'danhgiaTThcldhnview.php'),
        // Đánh Giá Cá Nhân
        'danhgiaCN' => array('Quản lý Đánh Giá Cá Nhân', 'danhgiaCNview.php'),
        'danhgiaCNsua' => array('Sửa Đánh Giá Cá Nhân', 'danhgiaCNsua.php'),
        'danhgiaCNthem' => array('Đánh Giá Cá Nhân', 'danhgiaCNthem.php'),
        'danhgiaCNkhoa' => array('Đánh Giá Cá Nhân', 'danhgiaCNviewkhoa.php'),
        
    );
    //connect các trang 
    include('../Admin/connectdb.php');
    //include('../client/theme.php'); 
    include('../Admin/them.php')
?>