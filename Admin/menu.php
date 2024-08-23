<?php
ob_start();
session_start();
?>
<h3>Chào <?php echo $_SESSION['VaiTro']; ?>: <?php echo $_SESSION['TenTk']; ?></h3>
<ul class="nav nav-pills nav-stacked">
    <li><a href="<?php echo "$baseUrl?p=trangchinh"; ?>" ><?php echo $pages['trangchinh'][0]; ?> <i class="fa-solid fa-house"></i></a></li>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Khoa'){?>
        <li><a href="<?php echo "$baseUrl?p=danhgiaTT"; ?>"><?php echo $pages['danhgiaTT'][0]; ?> <i class="fa-solid fa-file-alt"></i></a></li>
        <ul>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTTtientienview"; ?>"><?php echo $pages['danhgiaTTtientienview'][0]; ?> <i class="fa-solid fa-medal"></i></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTTxs"; ?>"><?php echo $pages['danhgiaTTxs'][0]; ?> <i class="fa-solid fa-star"></i></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThieutruong"; ?>"><?php echo $pages['danhgiaTThieutruong'][0]; ?> <i class="fa-solid fa-school"></i></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThubndtp"; ?>"><?php echo $pages['danhgiaTThubndtp'][0]; ?> <i class="fa-solid fa-city"></i></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTTttcpview"; ?>"><?php echo $pages['danhgiaTTttcpview'][0]; ?> <i class="fa-solid fa-university"></i></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhbview"; ?>"><?php echo $pages['danhgiaTThcldhbview'][0]; ?> <i class="fa-solid fa-building"></i></a></li>
            <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhnview"; ?>"><?php echo $pages['danhgiaTThcldhnview'][0]; ?> <i class="fa-solid fa-landmark"></i></i></a></li>
        </ul>
    <?php } ?>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Giảng Viên'){?>
        <li><a href="<?php echo "$baseUrl?p=danhgiaCN"; ?>"><?php echo $pages['danhgiaCN'][0]; ?> <i class="fa-solid fa-chart-bar"></i></a></li>
        <li><a href="<?php echo "$baseUrl?p=sangkien"; ?>"><?php echo $pages['sangkien'][0]; ?> <i class="fa-solid fa-ranking-star"></i></a></li>
    <?php } ?>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?>
        <li><a href="<?php echo "$baseUrl?p=thongtincanhan"; ?>"><?php echo $pages['thongtincanhan'][0]; ?> <i class="fa-solid fa-users-line"></i></a></li>
        <li><a href="<?php echo "$baseUrl?p=Khoa"; ?>"><?php echo $pages['Khoa'][0]; ?> <i class="fa-solid fa-hotel"></i></a></li>
        <li><a href="<?php echo "$baseUrl?p=sangkien"; ?>"><?php echo $pages['sangkien'][0]; ?> <i class="fa-solid fa-ranking-star"></i></a></li>
        <li><a href="<?php echo "$baseUrl?p=danhgiaTT"; ?>"><?php echo $pages['danhgiaTT'][0]; ?> <i class="fa-solid fa-file-alt"></i></a></li>
        <li><a href="<?php echo "$baseUrl?p=danhgiaCN"; ?>"><?php echo $pages['danhgiaCN'][0]; ?> <i class="fa-solid fa-chart-bar"></i></a></li>
        <li><a href="<?php echo "$baseUrl?p=taikhoan"; ?>"><?php echo $pages['taikhoan'][0]; ?> <i class="fa-solid fa-users"></i></a></li>
        
        <ul>
            <li>Khen Thưởng
                <ul>
                    <li>Cá Nhân
                        <ul>
                            <!-- Add subitems here if any -->
                        </ul>
                    </li>
                    <li>Tập Thể
                        <ul>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTTtientienview";?>"><?php echo $pages['danhgiaTTtientienview'][0];?><i class="fa-solid fa-medal"></i></a></li>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTTxs";?>"><?php echo $pages['danhgiaTTxs'][0];?><i class="fa-solid fa-star"></i></a></li>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTThieutruong";?>"><?php echo $pages['danhgiaTThieutruong'][0];?><i class="fa-solid fa-school"></i></a></li>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTThubndtp";?>"><?php echo $pages['danhgiaTThubndtp'][0];?><i class="fa-solid fa-city"></i></a></li>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTTttcpview";?>"><?php echo $pages['danhgiaTTttcpview'][0];?><i class="fa-solid fa-university"></i></a></li>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhbview";?>"><?php echo $pages['danhgiaTThcldhbview'][0];?><i class="fa-solid fa-building"></i></a></li>
                        <li><a href="<?php echo "$baseUrl?p=danhgiaTThcldhnview";?>"><?php echo $pages['danhgiaTThcldhnview'][0];?><i class="fa-solid fa-landmark"></i></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <li><a href="<?php echo "$baseUrl?p=Nam"; ?>"><?php echo $pages['Nam'][0];?> <i class="fa-solid fa-calendar"></i></a></li>
    <?php } ?>
    <li><a href="<?php echo "$baseUrl?p=taikhoansua"; ?>"><?php echo $pages['taikhoansua'][0]; ?> <i class="fa-solid fa-user-edit"></i></a></li>
    <li><a href="<?php echo "$baseUrl?p=dangxuat"; ?>"><i class="fa-solid fa-sign-out-alt"></i></a></li>
</ul>
<?php ob_end_flush(); ?>