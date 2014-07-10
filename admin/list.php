<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Mitglieder</title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
    <?php
    if    (isset($_POST['save'])) {
        $checkboxes = array("electro", "alternativ", "hiphop", "live", "good_taste", "quiz", "studenten", "kleinkunst");
        foreach($checkboxes as $checkbox){
            if(!isset($_POST[$checkbox])){$checked=0;} else {$checked=1;}
            $_POST[$checkbox]=$checked;
        }
        unset($_POST['save']);unset($_POST['save_x']);unset($_POST['save_y']);
        foreach ($_POST as $key => $value) {
            if ($key == "id" or $key == "ratten" or $key == "namesearch") {}
                else { update_db($_POST['id'],$_POST[$key],$key);}
        }
    }
    ?>
</head>
<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <?php if (isset($_GET['ratten'])) {$id_array = create_id_array($_GET['ratten'],ratten,$_GET['sort']);}
        elseif (isset($_POST['ratten'])) {$_GET['ratten'] = $_POST['ratten']; $id_array = create_id_array($_POST['ratten'],ratten,$_GET['sort']);}
        elseif (isset($_POST['namesearch'])) {$id_array = create_id_array($_POST['namesearch'],name,$_GET['sort']);}
        else {$id_array = array();}

        if (isset($_GET['ratten']) or isset($_POST['namesearch']) or isset($_POST['ratten'])){ ?>
        <ul id=legend>
            <li class=nummer><a href="?sort=id&ratten=<?php echo $_GET['ratten'];?>"> <img alt=ID src="/media/images/id.png"></a></li>
            <li class=name><a href="?sort=name&ratten=<?php echo $_GET['ratten'];?>"><img alt=NAME src="/media/images/name.png"></a></li>
            <li class=email><a href="?sort=email&ratten=<?php echo $_GET['ratten'];?>"><img alt=EMAIL src="/media/images/email_transp.png"></a></li>
            <li class=telefon><a href="?sort=telefon&ratten=<?php echo $_GET['ratten'];?>"><img alt=TELEFON src="/media/images/tel.png"></a></li>
            <li class=boxes></li>
            <li class=lastvisit><a href="?sort=lastvisit&ratten=<?php echo $_GET['ratten'];?>"><img alt=DATUM src="/media/images/clock.png"></a></li>
            <li class=visit_count><a href="?sort=visit_count&ratten=<?php echo $_GET['ratten'];?>"><img alt=BESUCHE width=40 src="/media/images/times.png"></a></li>
            <li class=save></li>
        </ul>
        <?php 
                foreach ($id_array as $key) {
            $row = select_row($key); ?>
            <form method=post class=table_row action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'#'.$key;?>?sort=<?php echo $_GET['sort'];?>&ratten=<?php echo $_GET['ratten'];?>" id="<?php echo $key;?>" >
                <input type=hidden name=ratten value="<?php echo $row['ratten'];?>" >
                <input class=nummer name=id value="<?php echo $row['id'];?>" type=text readonly>
                <input class=name name=name value="<?php echo $row['name'];?>" type=text>
                <input class=email name=email value="<?php echo $row['email'];?>" type=text>
                <input class=telefon name=telefon value="<?php echo $row['telefon'];?>" type=text>
                <div class=boxes>
                    <a href="#box<?php echo $key;?>" ></a>
                    <article id="box<?php echo $key;?>" >
                        <figure>
                            <ul>
                                <li><input class=checkbox id="electro" name=electro value=1 type=checkbox <?php if($row['electro']==1) {echo "checked";}?> ><div class=label ><label for="electro" >Elektro</label></div></li>
                                <li><input class=checkbox id="alternativ" name=alternativ value=1 type=checkbox <?php if($row['alternativ']==1) {echo "checked";}?> ><div class=label ><label for="alternativ" >Alternativ</label></div></li>
                                <li><input class=checkbox id="hiphop" name=hiphop value=1 type=checkbox <?php if($row['hiphop']==1) {echo "checked";}?> ><div class=label ><label for="hiphop" >Hip Hop</label></div></li>
                                <li><input class=checkbox id="live" name=live value=1 type=checkbox <?php if($row['live']==1) {echo "checked";}?> ><div class=label ><label for="live" >Live</label></div></li>
                                <li><input class=checkbox id="good_taste" name=good_taste value=1 type=checkbox <?php if($row['good_taste']==1) {echo "checked";}?> ><div class=label ><label for="good_taste" >Good taste</label></div></li>
                                <li><input class=checkbox id="quiz" name=quiz value=1 type=checkbox <?php if($row['quiz']==1) {echo "checked";}?> ><div class=label ><label for="quiz" >Quiz</label></div></li>
                                <li><input class=checkbox id="studenten" name=studenten value=1 type=checkbox <?php if($row['studenten']==1) {echo "checked";}?> ><div class=label ><label for="studenten" >Studenten</label></div></li>
                                <li><input class=checkbox id="kleinkunst" name=kleinkunst value=1 type=checkbox <?php if($row['kleinkunst']==1) {echo "checked";}?> ><div class=label ><label for="kleinkunst" >Kleinkunst</label></div></li>
                                <li><input class=save id="save" name=save value=save type=image form="<?php echo $key;?>" src="/media/images/save.png"><div class=label ><label for="save" >Speichern</label></div></li>
                                <li><a href="#close" >Schliessen</a></li>
                            </ul>
                        </figure>
                    </article>
                </div>
                <input class=lastvisit name=lastvisit value=<?php echo date('d/m', strtotime($row['lastvisit']));?> type=text disabled>
                <input class=visit_count name=visit_count value=<?php echo $row['visit_count'];?> type=text disabled>
                <input class=save name=save value=save type=image form="<?php echo $key;?>" src="/media/images/save.png">
            </form>
            <?php
        }
        if (isset($_GET['ratten']) or isset($_POST['ratten'])) { ?>
        <form method=post class=table_row action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#new" id=new >
            <input type=hidden name=ratten value="<?php echo $_GET['ratten'];?>" >
            <input class=nummer name=id type=number >
            <input class=name name=name type=text >
            <input class=save name=new value=NEU type=image form=new src="/media/images/new.png" >
            <?php 
            if (isset($_POST['new'])) {
                if (check_for_row($_POST['id'])) { ?>
                <input class="error" value="Nummer existiert schon!" disabled>
                <?php 
            }
            elseif (!check_for_row($_POST['id']))   {
                add_to_db($_POST['id'],$_POST['name']); ?>
                <input class="message" value="Mitglied hinzugefügt!" disabled>
                <?php 
            } 
        }
    }
}?>
        
</div>
</body>
</html>
