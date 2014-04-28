<?php session_start(); ?>
<!DOCTYPE html>


<html lang="">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
        <title>Lager</title>
        <link rel="stylesheet" type="text/css" href="../media/global.css">
        <link rel="stylesheet" type="text/css" href="/media/lager.css">
        <?php include $_SERVER["DOCUMENT_ROOT"].'/includes/lager.php' ?>
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
if (isset($_GET['datum'])) {
    foreach (waren(kasten) as $typ) { liefer_row($typ,kasten); }
    foreach (waren(flasche) as $typ) { liefer_row($typ,flasche); }
}
else {
    echo "<form id=datum method=get action=\"".$_SERVER["PHP_SELF"]."\">";
    echo "<input type=date name=datum >";
    echo "<input type=submit >";
    echo "</form>";
}
            ?>
        </div>
        <div id=debug>
            <?php debug(); ?>
        </div>
    </body>

</html>
