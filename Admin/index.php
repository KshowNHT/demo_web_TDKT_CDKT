<?php

    $baseUrl = $_SERVER['PHP_SELF'];
    $pages = array(
        'trangchinh' => array('Trang Chủ', 'trangchinh.php'),
        'dangnhap' => array('Đăng Nhập', 'dangnhap.php'),
        'dangki' => array('Đăng Kí Tài Khoản', 'dangkiview.php'),
        'taikhoan' => array('Quản lý Tài Khoản', 'taikhoanview.php'),
        'taikhoanxoa' => array('Xóa Tài Khoản', 'taikhoanxoa.php'),
        'taikhoansua' => array('Đổi Mật Khẩu', 'doimatkhau.php'),
        'dangxuat' => array('Đăng Xuất', 'dangxuat.php'),
        'dexuatkhenthuong' => array('Đề Xuất Khen Thưởng ', 'dexuatdanhgiaview.php'),
        'xuatdanhgiaxlsx' => array('Đánh Giá Tập Thể Excel ', 'danhgiaTTxlsx.php'),
        // Thông Tin Cá Nhân
        'thongtincanhan' => array('Quản Lý Thông Tin Cá Nhân', 'thongtincanhanview.php'),
        'thongtincanhanth' => array('Thêm Thông Tin', 'thongtincanhanthem.php'),
        'thongtincanhansua' => array('Sửa Thông Tin', 'thongtincanhansua.php'),
        'thongtincanhanxoa' => array('Xóa Thông Tin', 'thongtincanhanxoa.php'),
        //Khoa
        'Khoa' => array('Quản lý Đơn Vị', 'khoaview.php'),
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
        'danhgiaTTtientienview' => array('Lao Động Tiên Tiến', 'danhgiaTTtientienview.php'),
        'danhgiaTTxsvahieutruong' => array('Đánh Giá Tập Thể', 'xedanhgiaTTxsvahieutruong.php'),
        'danhgiaTTxs' => array('Tập Thể Lao Động Xuất Sắc', 'danhgiaTTxsview.php'),
        'danhgiaTThieutruong' => array('Tập Thể GK Hiệu Trưởng', 'danhgiaTThieutruongview.php'),
        'danhgiaTThubndtp' => array('Tập Thể BK UBNDTP', 'xetdanhgiaTTubndtpview.php'),
        'danhgiaTThubndtpthem' => array('Xét Đánh Giá Tập Thể BK UBNDTP', 'xetdanhgiaTTubndtpthem.php'),
        'xetdanhgiaTTsua' => array('Sửa Đánh Giá', 'xetdanhgiaTTsua.php'),
        'danhgiaTTttcpthem' => array('Xét Đánh Giá Tập Thể BK TTCP', 'xetdanhgiaTTttcpthem.php'),
        'danhgiaTTttcpview' => array('Tập Thể BK TTCP', 'xetdanhgiaTTttcpview.php'),
        'danhgiaTThcldhbthem' => array('Xét Đánh Giá Tập Thể Huân Chương Lao Động Hạng Ba', 'xetdanhgiaTThcldhbthem.php'),
        'danhgiaTThcldhbview' => array('Tập Thể Huân Chương Lao Động Hạng Ba', 'xetdanhgiaTThcldhbview.php'),
        'danhgiaTThcldhnthem' => array('Xét Đánh Giá Tập Thể', 'danhgiaTThcldhnthem.php'),
        'danhgiaTThcldhnview' => array(' Tập Thể Huân Chương Lao Động Hạng Nhì', 'danhgiaTThcldhnview.php'),
        // Đánh Giá Cá Nhân
        'danhgiaCN' => array('Quản lý Đánh Giá Cá Nhân', 'danhgiaCNview.php'),
        'danhgiaCNsua' => array('Sửa Đánh Giá Cá Nhân', 'danhgiaCNsua.php'),
        'danhgiaCNthem' => array('Đánh Giá Cá Nhân', 'danhgiaCNthem.php'),
        'danhgiaCNkhoa' => array('Đánh Giá Cá Nhân', 'danhgiaCNviewkhoa.php'),
        'khenthuongth' => array('Xét Đánh Giá Cá Nhân', 'khenthuongth.php'),
        'khenthuongtt' => array('Đánh Giá Cá Nhân Lao Động Tiên Tiến', 'khenthuongtt.php'),
        'khenthuonghieutruong' => array('Đánh Giá Cá Nhân Giấy Khen Hiệu Trưởng', 'khenthuonghieutruong.php'),
        'khenthuongcstdcs' => array('Đánh Giá Cá Nhân Chiến Sĩ Thi Đua Cơ Sở', 'khenthuongcstdcs.php'),
        'khenthuongcstdtp' => array('Đánh Giá Cá Nhân Chiến Sĩ Thi Đua Thành Phố', 'khenthuongcstdtp.php'),
        'khenthuongcstdtq' => array('Đánh Giá Cá Nhân Chiến Sĩ Thi Đua Toàn Quốc', 'khenthuongcstdtq.php'),
        'khenthuongubnd' => array('Đánh Giá Cá Nhân Bằng Khen Ủy Ban Nhân Thành Phố', 'khenthuongubndtp.php'),
        'khenthuongbkttcp' => array('Đánh Giá Cá Nhân Bằng Khen Thủ Tướng Chính Phủ', 'khenthuongttcp.php'),
        'khenthuonghb' => array('Đánh Giá Cá Nhân Huân Chương Lao Động Hạng Ba', 'khenthuonghcldhb.php'),
        'khenthuonghn' => array('Đánh Giá Cá Nhân Huân Chương Lao Động Hạng Nhì', 'khenthuonghcldhn.php'),
        // Sáng Kiên
        'sangkien' => array('Quản lý Sáng Kiến', 'sangkienview.php'),
        'sangkiensua' => array('Sửa Sáng Kiến', 'sangkiensua.php'),
        'sangkienth' => array('Thêm Sáng Kiến', 'sangkienth.php'),
        'sangkienxoa' => array('Xóa Sáng kiến', 'sangkienxoa.php'),
        'sangkienct' => array('Xem Chi Tiết Sáng kiến', 'sangkienct.php'),
        // Khen Thưởng Kỷ Luật Cá Nhân
        'ktkyluat' => array('Quản lý Khen Thưởng Kỷ Luật', 'ktkyluatview.php'),
        'ktkyluatsua' => array('Sửa Khen Thưởng Kỷ Luật', 'ktkyluatsua.php'),
        'ktkyluatth' => array('Thêm Khen Thưởng Kỷ Luật', 'ktkyluatthem.php'),
        'ktkyluatxoa' => array('Xóa Khen Thưởng Kỷ Luật', 'ktkyluatxoa.php'),
        // Khen Thưởng Kỷ Luật Tập Thể
        'kttt' => array('Quản lý Khen Thưởng Kỷ Luật', 'KTttview.php'),
        'ktsua' => array('Sửa Khen Thưởng', 'KTttsua.php'),
        'ktth' => array('Thêm Khen Thưởng', 'KTttth.php'),
        'ktxoa' => array('Xóa Khen Thưởng', 'KTttxoa.php'),
        
    );
    //connect các trang 
    include('../Admin/connectdb.php');
    include('../Admin/them.php')
?>