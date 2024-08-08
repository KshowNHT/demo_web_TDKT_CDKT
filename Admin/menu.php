<?php session_start();?>
<h3>Chào <?php echo $_SESSION['VaiTro']; ?>: <?php echo $_SESSION['TenTk']; ?></h3>
<ul class="nav nav-pills nav-stacked">
    <li><a href="<?php echo "$baseUrl?p=trangchinh"; ?>"><?php echo $pages['trangchinh'][0]; ?></a></li>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Khoa'){?>
        <li><a href="<?php echo "$baseUrl?p=danhgiaTT"; ?>"><?php echo $pages['danhgiaTT'][0]; ?></a></li>
        <ul>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTTtientienview"; ?>"><?php echo $pages['danhgiaTTtientienview'][0]; ?></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTTxs"; ?>"><?php echo $pages['danhgiaTTxs'][0]; ?></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThieutruong"; ?>"><?php echo $pages['danhgiaTThieutruong'][0]; ?></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThubndtp"; ?>"><?php echo $pages['danhgiaTThubndtp'][0]; ?></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTTttcpview"; ?>"><?php echo $pages['danhgiaTTttcpview'][0]; ?></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhbview"; ?>"><?php echo $pages['danhgiaTThcldhbview'][0]; ?></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhnview"; ?>"><?php echo $pages['danhgiaTThcldhnview'][0]; ?></a></li>
        </ul>
    <?php } ?>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Giảng Viên'){?>
        <li><a href="<?php echo "$baseUrl?p=danhgiaCN"; ?>"><?php echo $pages['danhgiaCN'][0]; ?></a></li>
        <li><a href="<?php echo "$baseUrl?p=sangkien"; ?>"><?php echo $pages['sangkien'][0]; ?></a></li>
    <?php } ?>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?>
        <li><a href="<?php echo "$baseUrl?p=thongtincanhan"; ?>"><?php echo $pages['thongtincanhan'][0]; ?></a></li>
        <li><a href="<?php echo "$baseUrl?p=Khoa"; ?>"><?php echo $pages['Khoa'][0]; ?></a></li>
        <li><a href="<?php echo "$baseUrl?p=sangkien"; ?>"><?php echo $pages['sangkien'][0]; ?></a></li>
        <li><a href="<?php echo "$baseUrl?p=danhgiaTT"; ?>"><?php echo $pages['danhgiaTT'][0]; ?></a></li>
        <li><a href="<?php echo "$baseUrl?p=danhgiaCN"; ?>"><?php echo $pages['danhgiaCN'][0]; ?></a></li>
        
        <ul>
            <li>Khen Thưởng
                <ul>
                    <li>Đánh Giá Cá Nhân
                        <ul>
                            <!-- Add subitems here if any -->
                        </ul>
                    </li>
                    <li>Đánh Giá Tập Thể
                        <ul>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTTtientienview"; ?>"><?php echo $pages['danhgiaTTtientienview'][0]; ?></a></li>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTTxs"; ?>"><?php echo $pages['danhgiaTTxs'][0]; ?></a></li>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTThieutruong"; ?>"><?php echo $pages['danhgiaTThieutruong'][0]; ?></a></li>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTThubndtp"; ?>"><?php echo $pages['danhgiaTThubndtp'][0]; ?></a></li>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTTttcpview"; ?>"><?php echo $pages['danhgiaTTttcpview'][0]; ?></a></li>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhbview"; ?>"><?php echo $pages['danhgiaTThcldhbview'][0]; ?></a></li>
                            <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhnview"; ?>"><?php echo $pages['danhgiaTThcldhnview'][0]; ?></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <li><a href="<?php echo "$baseUrl?p=Nam"; ?>"><?php echo $pages['Nam'][0]; ?></a></li>
        <li><a href="<?php echo "$baseUrl?p=dangki"; ?>"><?php echo $pages['dangki'][0]; ?></a></li>
    <?php } ?>
    <li><a href="<?php echo "$baseUrl?p=dangxuat"; ?>">Đăng Xuất</a></li>
</ul>
