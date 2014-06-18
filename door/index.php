<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
        <title>Tür Check</title>
        <?php require '../includes/door.php' ?>
   <link rel="stylesheet" type="text/css" href="/media/css/check.css">
    </head>
    <body>
        <div id="wrap" >
        <div class="id_form">
            <form method="post" id="check_id" name="check_id" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#result">
                <input type="number" name="id"><br>
                <input form="check_id" alt="Check" name="check_button" type="image" src="/media/images/check_number.png">
            </form>
        </div>
        <div id="result">
        <?php
if ($_SERVER["REQUEST_METHOD"]=="POST" and empty($_POST['id']) and empty($_POST['visit'])) {
        echo "<span class=\"error\">Nummer eingeben</span>" ;
    }
elseif(isset($_POST['visit'])) {add_lastvisit($_POST['visit']);visit_counter($_POST['visit']);}
elseif (isset($_POST['id'])) { ?>
            <br>
            <?php
    door_check(test_input($_POST['id']));
    if ($exist){ ?>
            <div>
                <form method="post" id="check_in_form" name="check_in_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="hidden" name="visit" value="<?php echo "$id"; ?>">
                    <input type="image" alt="Check In" name="check_in_button" form="check_in_form" src="/media/images/check_in.png">
                </form>
                <?php } } ?>
            </div>
        </div>
    </div>
    </body>
</html>
