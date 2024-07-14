<?php
    if(isset($_GET['p']))
    {
        $page = $_GET['p'];
    }else{

        $page = 'trangchinh';
    }
    
?>
<h4><?php echo $pages[$page][0]?></h4>
<hr/>
<?php
    include($pages[$page][1]);
?>


