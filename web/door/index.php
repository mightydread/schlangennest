<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700">
    <title>Tür Check</title>
    <?php require 'door.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/check.css">
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"]=="POST" and empty($_POST['id']) and empty($_POST['visit'])) {
        unset($_POST);
        echo "<script>";
        echo "alert('Nummer eingeben')";
        echo "</script>";
    }
    elseif(isset($_POST['visit'])) {add_lastvisit($_POST['id_visit']);visit_counter($_POST['id_visit']);}
    ?>
    <?php include 'icons_door.svg' ?>
    <div id="wrap" >
        <div class="input">
            <?php if(!isset($_POST['id'])){ ?>
            <form method="post" id="id_input" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="number" id="id" name="id" placeholder="Nummer">
            </form>
            <?php } if (isset($_POST['id'])) { door_check($_POST['id']);?>
            <div class="result <?php if ($result['check'] == "already_in" or $result['check'] == "invalid_number"){echo "red";}?>" >
                <?php if ($result['check'] == "exist") {
                    echo $result['name']."<ul>";
                    for ($i=0; $i < $result['ratten']; $i++) { 
                        echo "<li><svg><use xlink:href=\"#door_ratte\" /></svg></li>";
                    }
                    echo "</ul>";
                }
                elseif ($result['check']=="already_in") { echo "Heute schon registiert"; }
                elseif ($result['check']=="invalid_number") {echo "Nummer existiert nicht";} 
                ?>
            </div>
            <?php if ($result['check'] == "exist") { ?>
            <form method="post" id="visit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="number" name="id_visit" hidden value="<?php echo $_POST['id'];?>">
            </form>
            <?php }} ?>
        </div>
        <div class="buttons">
            <ul <?php if(isset($_POST['check'])){echo "class=\"all\""; }?>>
                <li <?php if(empty($_POST['id'])){ echo "class=\"big\"";?>><svg><use xlink:href="#door_check" /></svg><form><input type="submit" form="id_input" name="check"></form><?php }else{?>><a href="/door"><svg><use xlink:href="#door_back" /></svg></a><?php }?> </li>
                <li><svg><use xlink:href="#door_ok" /></svg><form><input type="submit" form="visit" name="visit"></form></li>
            </ul>
            <ul <?php if(isset($_POST['check'])){echo "class=\"all\""; }?>>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>
</body>
</html>
