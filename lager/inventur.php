<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Lager Inventur</title>
    <link rel="stylesheet" type="text/css" href="/media/css/lager.css">
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/lager.php' ?>
    <?php if (isset($_GET[ 'restart'])) { session_destroy(); } ?>
</head>
<body>
    <div id="wrap">
        <div id="inventur_wrap" >
            <?php 
            foreach (waren() as $key => $value) {
                $_SESSION[$key]=array("anzahl_k"=>"0","anzahl_fl"=>"0","abgang"=>"0");
            }
            foreach (waren(kasten) as $typ) {

                $$typ=$typ._ok;
                if (isset($_POST[$typ])) {
                    $_SESSION[$$typ] = "ok";
                    ende($_POST['typ'],$_POST[$typ._k],$_POST[$typ._fl]);
                    add_row($_POST['typ'],get_date());
                    anfang($_POST['typ'],$_POST[$typ._k],$_POST[$typ._fl],$_POST[$typ._abgang],get_date());
                    $_SESSION[$typ]['anzahl_k']=$_POST[$typ._k];
                    $_SESSION[$typ]['anzahl_fl']=$_POST[$typ._fl];
                    $_SESSION[$typ]['abgang']=$_POST[$typ._abgang];
                }
                if (isset($_SESSION[$$typ])) { ?>
                <form class="row_disabled" id="<?php echo $typ;?>_correct" method="post" onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo $_SERVER['PHP_SELF'];?>" >
                    <?php } else { ?>
                    <form class="row" id="<?php echo $typ;?>" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
                        <?php } ?>
                        <input type=hidden name=typ value="<?php echo $typ;?>">
                        <input type=hidden name=datum value="<?php echo get_date();?>">
                        <label for="<?php echo $typ;?>_k" class="name"><?php echo full_name($typ);?></label>
                        <input id="<?php echo $typ;?>_k" class=anzahl type=number step=any value="<?php echo  $_SESSION[$typ][anzahl_k];?>" min=0 name="<?php echo $typ;?>_k" >
                        <input class=anzahl type=number step=any value="<?php echo  $_SESSION[$typ][anzahl_fl];?>" min=0 name="<?php echo $typ;?>_fl" >
                        <input class=anzahl type=number step=any value="<?php echo  $_SESSION[$typ][abgang];?>" min=0 name="<?php echo $typ;?>_abgang" >
                        <input class=save type=submit form="<?php echo $typ;?>" name="<?php echo $typ;?>" src="/media/images/save.png">
                        <input class=save_correct type=submit form="<?php echo $typ;?>_correct" name="<?php echo $typ;?>" src="/media/images/save.png">
                    </form>
                </ul>
                <?php }?>
            </div>  
        </div>
    </body>
    </html>
