<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
        <title>Development Area</title>
        <?php require '../includes/admin.php' ?>
        <?php require '../includes/door.php' ?>
        <?php require '../includes/lager.php' ?>

        <link rel="stylesheet" type="text/css" href="../media/css/admin.css">
    </head>
    <body>
        Sucess!!!<br>
        
        <div class="bestand">
            <?php foreach (waren(kasten) as $typ) { ?>
                <a href="#<?php echo $typ; ?>" ><?php bestand($typ);?></a>
            <?php } foreach (waren(flasche) as $typ) { ?>
                <a href="#<?php echo $typ; ?>" ><?php bestand($typ);?></a>
            <?php } ?>
        </div>
    
    </body>
</html>
