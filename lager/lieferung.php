<?php session_start(); ?>
<!DOCTYPE html>


<html lang="de">

    <head>

        <title>Lager Lieferung</title>
        <link rel="stylesheet" type="text/css" href="/media/global.css">
        <link rel="stylesheet" type="text/css" href="/media/lager.css">
        <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/lager.php' ?>
    </head>

    <body>
        <div>
            <?php if (isset($_GET['restart'])) { session_destroy(); } ?>
            <form method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <input type="submit" name="restart" value="Restart">
            </form>
        </div>
        <div class="wrap">
            <?php
if (isset($_POST['datum'])) {
    echo "<div class=legend_row><div class=name>Kastenware</div><div class=anzahl>Kasten</div><div class=save></div></div>";
    foreach (waren(kasten) as $typ) { liefer_row($typ); }
    echo "<div class=legend_row><div class=name>Flaschenware</div><div class=anzahl>volle Flaschen</div><div class=save></div></div>";
    foreach (waren(flasche) as $typ) { liefer_row($typ); }
}
else {
    echo "Bitte Datum der nächsten Schicht nehmen!";
    echo "<form id=datum method=post action=\"".$_SERVER["PHP_SELF"]."\">";
    echo "<input type=date name=datum >";
    echo "<input type=submit >";
    echo "</form>";
}
            ?>
        </div>
    </body>

</html>
