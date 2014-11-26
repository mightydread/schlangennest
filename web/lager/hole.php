<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700px">
    <title>Lager Loch</title>
    <link rel="stylesheet" type="text/css" href="/media/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/media/css/lager.css">
    <?php require 'lager.php' ?>
</head>
    <body>
        <div id="wrap">
        <?php include 'navbar.php' ?>
            <div id="inventur_wrap" >
            <?php 

            foreach (waren() as $typ) {
                if (isset($_POST[$typ])) {
                    if ($_POST[$typ.'_hole'] == '') {
                        $_SESSION[$typ]['hole']= 0;
                    }
                    else {
                        $_SESSION[$typ]['hole']=$_POST[$typ.'_hole'];
                    }
                    add_row($typ,get_date());
                    hole($typ,$_SESSION[$typ]['st'],$_SESSION[$typ]['hole'],get_date());
                    $_SESSION[$typ]['done_hole'] = "ok";
                } ?>
                <ul>
                    <form id="<?php echo $typ;?>" method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>" <?php if(isset($_SESSION[$typ]['done_hole'])){?>class="done" onsubmit="return confirm('Korrektur vornehmen?');"<?php }?>>
                        <label for="<?php echo $typ;?>_hole" class="name"><?php echo full_name($typ);?></label>
                        <li></li><li></li>
                        <li><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "Kasten";} else { echo "Flaschen";}?></li>
                        <input id="<?php echo $typ;?>_hole" class=anzahl type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['hole'];?>" min=0 name="<?php echo $typ;?>_hole" >
                        <li class="button"><svg><use xlink:href="#lager_check" /></svg><input type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>"></li>
                    </form>
                </ul>
                <?php }?>
            </div>  
        </div>
    </body>
</html>
