<?php if (isset($_GET[ 'restart'])) { session_destroy(); } ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700px">
    <title>Lager Abgang</title>
    <link rel="stylesheet" type="text/css" href="/media/css/lager.css">
    <?php require 'lager.php' ?>
</head>
    <body>
    <?php include 'icons.svg' ?>
        <div id="wrap">
        <?php include 'navbar.php' ?>
            <div id="inventur_wrap" >
            <?php 
            foreach (waren() as $typ) {
                if (!isset($_SESSION[$typ]['art']) or !isset($_SESSION[$typ]['a'])) {$_SESSION[$typ]=array("a"=>"0","art"=>info($typ)['art']);}
                if (isset($_POST[$typ])) {
                    if ($_POST[$typ.'_a'] == '') {
                        $_SESSION[$typ]['a']= 0;
                    }
                    else {
                        $_SESSION[$typ]['a']=$_POST[$typ.'_a'];
                    }
                    add_row($typ,get_date());
                    abgang($typ,$_SESSION[$typ]['a'],get_date());
                    $_SESSION[$typ]['done_ab'] = "ok";
                } ?>
                <ul>
                    <form id="<?php echo $typ;?>" method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>" <?php if(isset($_SESSION[$typ]['done_ab'])){?>class="done" onsubmit="return confirm('Korrwktur vornehmen?');"<?php }?>>
                        <label for="<?php echo $typ;?>_a" class="name"><?php echo full_name($typ);?></label>
                        <li></li><li></li>
                        <li><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "Flaschen";} else { echo "Anbruch";}?></li>
                        <input id="<?php echo $typ;?>_a" class=anzahl type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['a'];?>" min=0 name="<?php echo $typ;?>_a" >
                        <li class="button"><svg><use xlink:href="#icons_check" /></svg><input type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>"></li>
                    </form>
                </ul>
                <?php }?>
            </div>  
        </div>
    </body>
</html>
