<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
        <meta name="viewport" content="width=600px">
        <title>Tür Check</title>
        <?php require '../includes/door.php' ?>
        <?php if ($_SERVER["REQUEST_METHOD"]=="POST" ) {
    if (empty($_POST['id']) and empty($_POST['visit'])) {
        $idErr="Nummer eingeben" ;
    }
    elseif  (empty($_POST['id']) and isset($_POST['visit']))    {

    }
    else {
        $id=test_input($_POST['id']);
    }
} ?>

        <link rel="stylesheet" type="text/css" href="/media/css/check.css">
    </head>
    <body>
        <div class="id_form">
            <form method="post" id="check_id" name="check_id" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="number" name="id"><br>
                <input form="check_id" alt="Check" name="check_button" type="image" src="/media/images/check_number.png">
            </form>
        </div>
        <?php
if ($idErr) {echo "<br><div class=\"error\">" .$idErr. "</div>";}
if(isset($_POST['visit'])) {add_lastvisit($_POST['visit']);visit_counter($_POST['visit']);}
elseif ($id){ ?>
        <div class="result">
            <br>
            <?php
    door_check($id);
    echo "</div>";
    if ($exist){ ?>
            <div>
                <form method="post" id="check_in_form" name="check_in_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="hidden" name="visit" value="<?php echo "$id"; ?>">
                    <input type="image" alt="Check In" name="check_in_button" form="check_in_form" src="/media/images/check_in.png">
                </form>
                <?php } } ?>
            </div>
        </div>
    </body>
</html>
