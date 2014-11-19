<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700px">
    <title>Lager Inventur</title>
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

                } ?>
                
                <ul>
                    <form id="<?php echo $typ;?>" method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>#<?php echo $typ;?>" <?php if(isset($_SESSION[$typ]['done_inv'])){?>class="done" onsubmit="return confirm('Korrwktur vornehmen?');"<?php }?>>
                    <label for="<?php echo $typ;?>_g"><?php echo full_name($typ);?></label>
                    <li><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "Kasten";} else { echo round($_SESSION[$typ]['st'],2)." l Fl";}?></li>
                    <input id="<?php echo $typ;?>_g" class=anzahl type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['i_g'];?>" min=0 name="<?php echo $typ;?>_g" >
                    <li><?php if ($_SESSION[$typ]['art'] == "kasten"){ echo "Flaschen";} else { echo "Anbruch";}?></li>
                    <input type=number step=any onfocus="this.value = '';" value="<?php echo  $_SESSION[$typ]['i_k'];?>" min=0 name="<?php echo $typ;?>_k" >
                    <li class="button"><svg><use xlink:href="#lager_check" /></svg><input type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>"></li>
                    </form>
                </ul>
            <?php }?>
        </div>  
    </div>
    <?php print_r($_SESSION); ?> 
</body>
</html>
