<!DOCTYPE html>
<html lang="en">

<head>
 <?= $this->include('layouts/head') ?>   
</head>

<body id="app-container" class="menu-default show-spinner">


    <?php if(!isset($_SESSION['user_id'])): ?>
    <!-- <meta http-equiv="refresh" content="0; URL=http://localhost/hrms" />  --> 
    <?php header("Location: http://localhost/hrms");
     exit();
     ?>

    <?php else :?>
    <?= $this->include('layouts/navbar') ?> 
    <?= $this->include('layouts/sidebar') ?>    
     <?= $this->renderSection('main-content') ?>


    <?= $this->include('layouts/footer') ?>     
    <?php endif ;?>

    
</body>

</html>