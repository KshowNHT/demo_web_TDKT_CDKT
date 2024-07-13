<?php session_start();?>
<h3>Chào <?php echo $_SESSION['VaiTro']; ?>: <?php echo $_SESSION['TenTk']; ?> </h3>
<ul class="nav nav-pills nav-stacked">
    <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=trangchinh"; ?>"><?php echo $pages['trangchinh'][0]; ?></a></li>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Khoa'){?>
    <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=danhgiaTT"; ?>"><?php echo $pages['danhgiaTT'][0]; ?></a></li>
    <?php
    }
    ?>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Giảng Viên'){?>
    <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=danhgiaCN"; ?>"><?php echo $pages['danhgiaCN'][0]; ?></a></li>
    <?php
    }
    ?>
    <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị'){?>
        <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=thongtincanhan"; ?>"><?php echo $pages['thongtincanhan'][0]; ?></a></li>
        <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=Khoa"; ?>"><?php echo $pages['Khoa'][0]; ?></a></li>
        <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=danhgiaTT"; ?>"><?php echo $pages['danhgiaTT'][0]; ?></a></li>
        <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=danhgiaCN"; ?>"><?php echo $pages['danhgiaCN'][0]; ?></a></li>
        <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=dangki"; ?>"><?php echo $pages['dangki'][0]; ?></a></li>
    <?php
    }
    ?>
    <li style="font-weight: bold;font-size: 18px;color: #e5e5e5;"><a href="<?php echo " $baseUrl?p=dangxuat"; ?>"><?php echo $pages['dangxuat'][0]; ?></a></li>
</ul>