<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Lager Lieferung</title>
    <link rel="stylesheet" type="text/css" href="/media/css/lager.css">
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/lager.php' ?>
    <?php if (isset($_GET[ 'restart'])) { session_destroy(); } ?>
</head>
    <body>
        <div id="wrap">
            <div id="inventur_wrap" >
            <?php 
            foreach (waren() as $typ) {
                if (!isset($_SESSION[$typ])) {$_SESSION[$typ]=array("z"=>"0");}
                if (isset($_POST[$typ])) {
                    $_SESSION[$typ]['z']=$_POST[$typ._z];                    
                    add_row($typ,get_date());
                    zugang($typ,$_SESSION[$typ]['z'],get_date());
                    $_SESSION[$typ]['done'] = "ok";
                }
                if (isset($_SESSION[$typ]['done'])) { ?>
                <form class="row_disabled" id="<?php echo $typ;?>_correct" method="post" onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>_correct" >
                    <?php } else { ?>
                    <form class="row" id="<?php echo $typ;?>" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>_correct" >
                        <?php } ?>
                        <label for="<?php echo $typ;?>_z" class="name"><?php echo full_name($typ);?></label>
                        <div class="info">Kasten<br>Flaschen</div><input id="<?php echo $typ;?>_z" class=anzahl type=number step=any value="<?php echo  $_SESSION[$typ]['z'];?>" min=0 name="<?php echo $typ;?>_z" >
                        <input class=save type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>" src="/media/images/save.png">
                        <input class=save_correct type=submit form="<?php echo $typ;?>_correct" name="<?php echo $typ;?>" src="/media/images/save.png">
                    </form>
                </ul>
                <?php }?>
            </div>  
        </div>
    </body>
</html>
