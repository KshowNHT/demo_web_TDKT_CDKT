<?php
ob_start();
session_start();
?>
<div class="sidebar">
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="info">
        <a href="#" class="d-block"> Chào <?php echo $_SESSION['VaiTro']; ?>: <?php echo $_SESSION['TenTk']; ?> </a>
    </div>
</div>      
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Khoa'){?>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=danhgiaTT"; ?>" class="nav-link">
                    <i class="fa-solid fa-file-alt"></i>
                    <P> <?php echo $pages['danhgiaTT'][0]; ?> </P> 
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=dexuatkhenthuong"; ?>" class="nav-link">
                   <p> <?php echo $pages['dexuatkhenthuong'][0];?> </p>
                </a>
             </li>
             <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                   <p> 
                                        Quản Lý Khen Thưởng Tập Thể
                                        <i class="fas fa-angle-left right"></i>
                                   </p>
                                </a>
                                <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTTtientienview";?>" class="nav-link">
                                        <i class="fa-solid fa-medal"></i>
                                        <p><?php echo $pages['danhgiaTTtientienview'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTTxs";?>" class="nav-link">
                                        <i class="fa-solid fa-star"></i>
                                        <p> <?php echo $pages['danhgiaTTxs'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThieutruong";?>" class="nav-link">
                                        <i class="fa-solid fa-school"></i>
                                        <p> <?php echo $pages['danhgiaTThieutruong'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThubndtp";?>" class="nav-link">
                                        <i class="fa-solid fa-city"></i>
                                        <p> <?php echo $pages['danhgiaTThubndtp'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTTttcpview";?>" class="nav-link">
                                        <i class="fa-solid fa-university"></i>
                                        <p> <?php echo $pages['danhgiaTTttcpview'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThcldhbview";?>" class="nav-link">
                                        <i class="fa-solid fa-building"></i>
                                        <P> <?php echo $pages['danhgiaTThcldhbview'][0];?> </P>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThcldhnview";?>" class="nav-link">
                                        <i class="fa-solid fa-landmark"></i>
                                        <p> <?php echo $pages['danhgiaTThcldhnview'][0];?> </p>
                                    </a>
                                </li>
                                </ul>
                            </li>
        <?php } ?>
        <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Giảng Viên'){?>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=danhgiaCN"; ?>" class="nav-link">
                    <i class="fa-solid fa-chart-bar"></i>
                   <p> <?php echo $pages['danhgiaCN'][0]; ?> </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=sangkien"; ?>" class="nav-link">
                    <i class="fa-solid fa-ranking-star"></i>
                   <p> <?php echo $pages['sangkien'][0]; ?> </p> 
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=dexuatkhenthuongcn"; ?>" class="nav-link">
                   <p> <?php echo $pages['dexuatkhenthuongcn'][0];?> </p>
                </a>
             </li>
            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                   <p> 
                                        Quản Lý Khen Thưởng Cá Nhân
                                        <i class="fas fa-angle-left right"></i>
                                   </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongtt";?>" class="nav-link">
                                            <i class="fa-solid fa-medal"></i>
                                            <p><?php echo $pages['khenthuongtt'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuonghieutruong";?>" class="nav-link">
                                            <i class="fa-solid fa-star"></i>
                                            <p> <?php echo $pages['khenthuonghieutruong'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongcstdcs";?>" class="nav-link">
                                            <i class="fa-solid fa-school"></i>
                                            <p> <?php echo $pages['khenthuongcstdcs'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongcstdtp";?>" class="nav-link">
                                            <i class="fa-solid fa-city"></i>
                                            <p> <?php echo $pages['khenthuongcstdtp'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongcstdtq";?>" class="nav-link">
                                            <i class="fa-solid fa-university"></i>
                                            <p> <?php echo $pages['khenthuongcstdtq'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongubnd";?>" class="nav-link">
                                            <i class="fa-solid fa-building"></i>
                                            <P> <?php echo $pages['khenthuongubnd'][0];?> </P>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongbkttcp";?>" class="nav-link">
                                            <i class="fa-solid fa-landmark"></i>
                                            <p> <?php echo $pages['khenthuongbkttcp'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuonghb";?>" class="nav-link">
                                            <i class="fa-solid fa-landmark"></i>
                                            <p> <?php echo $pages['khenthuonghb'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuonghn";?>" class="nav-link">
                                            <i class="fa-solid fa-landmark"></i>
                                            <p> <?php echo $pages['khenthuonghn'][0];?> </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
        <?php } ?>
        <?php if(isset($_SESSION['VaiTro']) && $_SESSION['VaiTro'] === 'Quản Trị'){ ?>
            <li class="nav-item" >
                <a href="<?php echo "$baseUrl?p=thongtincanhan"; ?>" class="nav-link">
                    <i class="fa-solid fa-users-line"></i>
                   <p> <?php echo $pages['thongtincanhan'][0]; ?></p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=Khoa"; ?>" class="nav-link">
                    <i class="fa-solid fa-hotel"></i>
                   <P> <?php echo $pages['Khoa'][0]; ?> </P>
                   <i class="fas fa-angle-left right"></i>
                </a>
            
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo "$baseUrl?p=tudanhgia"; ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                <p> 
                                        <?php echo $pages['tudanhgia'][0]; ?>
                                </p>
                                </a>
                            </li>   
                        </ul>
            </li>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=sangkien"; ?>" class="nav-link">
                    <i class="fa-solid fa-ranking-star"></i>
                   <p> <?php echo $pages['sangkien'][0]; ?> </p> 
                </a>
            </li>
             <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=danhgiaTT"; ?>" class="nav-link">
                    <i class="fa-solid fa-file-alt"></i>
                    <P> <?php echo $pages['danhgiaTT'][0]; ?> </P> 
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=danhgiaCN"; ?>" class="nav-link">
                    <i class="fa-solid fa-chart-bar"></i>
                   <p> <?php echo $pages['danhgiaCN'][0]; ?> </p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                 <p>
                     Quản Lý Khen Thưởng
                     <i class="fas fa-angle-left right"></i>
                 </p>
                </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                   <p> 
                                        Cá Nhân 
                                        <i class="fas fa-angle-left right"></i>
                                   </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongtt";?>" class="nav-link">
                                            <i class="fa-solid fa-medal"></i>
                                            <p><?php echo $pages['khenthuongtt'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuonghieutruong";?>" class="nav-link">
                                            <i class="fa-solid fa-star"></i>
                                            <p> <?php echo $pages['khenthuonghieutruong'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongcstdcs";?>" class="nav-link">
                                            <i class="fa-solid fa-school"></i>
                                            <p> <?php echo $pages['khenthuongcstdcs'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongcstdtp";?>" class="nav-link">
                                            <i class="fa-solid fa-city"></i>
                                            <p> <?php echo $pages['khenthuongcstdtp'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongcstdtq";?>" class="nav-link">
                                            <i class="fa-solid fa-university"></i>
                                            <p> <?php echo $pages['khenthuongcstdtq'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongubnd";?>" class="nav-link">
                                            <i class="fa-solid fa-building"></i>
                                            <P> <?php echo $pages['khenthuongubnd'][0];?> </P>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuongbkttcp";?>" class="nav-link">
                                            <i class="fa-solid fa-landmark"></i>
                                            <p> <?php echo $pages['khenthuongbkttcp'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuonghb";?>" class="nav-link">
                                            <i class="fa-solid fa-landmark"></i>
                                            <p> <?php echo $pages['khenthuonghb'][0];?> </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo "$baseUrl?p=khenthuonghn";?>" class="nav-link">
                                            <i class="fa-solid fa-landmark"></i>
                                            <p> <?php echo $pages['khenthuonghn'][0];?> </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                   <p> 
                                        Tập Thể
                                        <i class="fas fa-angle-left right"></i>
                                   </p>
                                </a>
                                <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTTtientienview";?>" class="nav-link">
                                        <i class="fa-solid fa-medal"></i>
                                        <p><?php echo $pages['danhgiaTTtientienview'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTTxs";?>" class="nav-link">
                                        <i class="fa-solid fa-star"></i>
                                        <p> <?php echo $pages['danhgiaTTxs'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThieutruong";?>" class="nav-link">
                                        <i class="fa-solid fa-school"></i>
                                        <p> <?php echo $pages['danhgiaTThieutruong'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThubndtp";?>" class="nav-link">
                                        <i class="fa-solid fa-city"></i>
                                        <p> <?php echo $pages['danhgiaTThubndtp'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTTttcpview";?>" class="nav-link">
                                        <i class="fa-solid fa-university"></i>
                                        <p> <?php echo $pages['danhgiaTTttcpview'][0];?> </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThcldhbview";?>" class="nav-link">
                                        <i class="fa-solid fa-building"></i>
                                        <P> <?php echo $pages['danhgiaTThcldhbview'][0];?> </P>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?php echo "$baseUrl?p=danhgiaTThcldhnview";?>" class="nav-link">
                                        <i class="fa-solid fa-landmark"></i>
                                        <p> <?php echo $pages['danhgiaTThcldhnview'][0];?> </p>
                                    </a>
                                </li>
                                </ul>
                            </li>
                        </ul>
            </li>
             <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=dexuatkhenthuong"; ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> <?php echo $pages['dexuatkhenthuong'][0];?> </p>
                </a>
             </li>
             <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=Nam"; ?>" class="nav-link">
                    <i class="fa-solid fa-calendar"></i>
                    <p> <?php echo $pages['Nam'][0];?> </p> 
                </a>
            </li>
             <li class="nav-item">
                <a href="<?php echo "$baseUrl?p=taikhoan"; ?>" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <p> <?php echo $pages['taikhoan'][0]; ?> </p> 
                </a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="<?php echo "$baseUrl?p=ktkyluat"; ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
               <p> Quản lý Khen Thưởng Kỷ Luật </p> 
            </a>
        </li>
         <li class="nav-item">
            <a href="<?php echo "$baseUrl?p=taikhoansua"; ?>" class="nav-link">
                <i class="fa-solid fa-user-edit"></i>
               <p> <?php echo $pages['taikhoansua'][0]; ?> </p> 
            </a>
        </li>
         <li class="nav-item">
            <a href="<?php echo "$baseUrl?p=dangxuat"; ?>" class="nav-link">
                <i class="fa-solid fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
</div>
<?php ob_end_flush(); ?>