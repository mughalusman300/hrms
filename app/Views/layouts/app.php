<!DOCTYPE html>
<html lang="en">

<head>
 <?= $this->include('layouts/head') ?>   
</head>

<body id="app-container" class="menu-default show-spinner">
    <?= $this->include('layouts/navbar') ?> 
    <?= $this->include('layouts/sidebar') ?> 

    <?php if(!isset($_SESSION['user_id'])){ ?>
    <meta http-equiv="refresh" content="0; URL=http://localhost/hrms" />  

    <?php } 
     else {?>
     <?= $this->renderSection('main-content') ?>
    <?php }
    ?>

    

    <?= $this->include('layouts/footer') ?>     
</body>

</html>