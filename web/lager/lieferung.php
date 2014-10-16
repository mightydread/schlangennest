<?php if (isset($_GET[ 'restart'])) { session_destroy(); } ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700px">
    <title>Lager Lieferung</title>
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
                if (!isset($_SESSION[$typ]['art']) or !isset($_SESSION[$typ]['zugang'])) {$_SESSION[$typ]=array("zugang"=>"0", "art"=>info($typ)['art']);}
                if (isset($_POST[$typ])) {
                    if ($_POST[$typ.'_z'] == '') {
                        $_SESSION[$typ]['zugang']= 0;
                    }
                    else {
                        $_SESSION[$typ]['zugang']=$_POST[$typ.'_z'];
                    }
                    add_row($typ,get_date());
                    zugang($typ,$_SESSION[$typ]['zugang'],get_date());
                    $_SESSION[$typ]['done_zg'] = "ok";
                } ?>
                <ul>
                    <form id="<?php echo $typ;?>" method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>" <?php if(isset($_SESSION[$typ]['done_zg'])){?>class="done" onsubmit="return confirm('Korrwktur vornehmen?');"<?php }?>>
                        <label for="<?php echo $typ;?>_z" class="name"><?php echo full_name($typ);?></label>
                        <li></li><li></li>
                        <li><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "Kasten";} else { echo round($_SESSION[$typ]['st'],2)." l Fl";}?></li>
                        <input id="<?php echo $typ;?>_z" class=anzahl type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['zugang'];?>" min=0 name="<?php echo $typ;?>_z" >
                        <li class="button"><svg><use xlink:href="#icons_check" /></svg><input type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>"></li>
                    </form>
                </ul>
                <?php }?>
            </div>  
        </div>
    </body>
</html>
