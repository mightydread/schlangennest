<?php if (isset($_GET[ 'restart'])) { session_destroy(); } ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Lager Inventur</title>
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
                if (!isset($_SESSION[$typ])) {$_SESSION[$typ]=array("i_g"=>"0","i_k"=>"0","st"=>info($typ)['st'],"art"=>info($typ)['art'],"preis"=>info($typ)['preis']);}
                if (!isset($_SESSION[$typ]['st']) or !isset($_SESSION[$typ]['art']) or !isset($_SESSION[$typ]['preis'])) {$_SESSION[$typ]=array("st"=>info($typ)['st'],"art"=>info($typ)['art'],"preis"=>info($typ)['preis']);}

                if (isset($_POST[$typ])) {
                    if ($_POST[$typ.'_g'] == '') {
                        $_SESSION[$typ]['i_g']= 0;
                    }
                    else {
                        $_SESSION[$typ]['i_g']=$_POST[$typ.'_g'];
                    }
                    if ($_POST[$typ.'_k'] == '') {
                        $_SESSION[$typ]['i_k']= 0;
                    }
                    else {
                        $_SESSION[$typ]['i_k']=$_POST[$typ.'_k'];
                    }
                    if (safety_check($typ,$_SESSION[$typ]['i_g'],$_SESSION[$typ]['i_k'],get_date())==0) { 
                        echo "<script>"; 
                        echo "alert('Mehr als letzes mal')";
                        echo "</script>";
                    }
                    add_row($typ,get_date());
                    inventur($typ,$_SESSION[$typ]['st'],$_SESSION[$typ]['i_g'],$_SESSION[$typ]['i_k'],get_date());
                    verbrauch($typ,$_SESSION[$typ]['st'],$_SESSION[$typ]['art'],$_SESSION[$typ]['preis'],get_date());
                    $_SESSION[$typ]['done_inv'] = "ok";

                }
                if (isset($_SESSION[$typ]['done_inv'])) { ?>
                <form class="row_disabled" id="<?php echo $typ;?>_correct" method="post" onsubmit="return confirm('Korrwktur vornehmen?');" action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>_correct" >
                    <?php } else { ?>
                    <form class="row" id="<?php echo $typ;?>" method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>_correct" >
                        <?php } ?>
                        <label for="<?php echo $typ;?>_g" class="name"><?php echo full_name($typ);?></label>
                        <div class="info"><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "K. :";} else { echo "Fl. :";}?></div><input id="<?php echo $typ;?>_g" class=anzahl type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['i_g'];?>" min=0 name="<?php echo $typ;?>_g" >
                        <div class="info"><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "Fl. :";} else { echo "Anbr. :";}?></div><input class=anzahl type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['i_k'];?>" min=0 name="<?php echo $typ;?>_k" >
                        <input class=save type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>" src="/media/images/save.png">
                        <input class=save_correct type=submit form="<?php echo $typ;?>_correct" name="<?php echo $typ;?>" src="/media/images/save.png">
                    </form>

                <?php }?>
            </div>  
        </div>
    </body>
    </html>
