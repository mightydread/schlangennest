<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=850px">
        <title>Lager Ausgabe</title>
        <?php require '../includes/admin.php' ?>

        <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
    </head>
    <body>

        <div id="wrap">
            <?php include 'navbar.php' ?>
            <div class="typ">
                Bestand
            </div>
            <div id="bestand">
                <?php
    foreach (waren(kasten) as $typ) {
    echo "<div class=bestand>";
    bestand($typ);
    echo "</div>";
}
foreach (waren(flasche) as $typ) {
    echo "<div class=bestand>";
    bestand($typ);
    echo "</div>";
}
                ?>
            </div>
            <?php
foreach (waren(kasten) as $typ) {
    echo "<div class=typ>";
    echo full_name($typ);
    echo "<br>";
    echo "<div class=tabelle>";
    tabelle_kasten($typ);
    echo "</div>";
    echo "</div>";
}
foreach (waren(flasche) as $typ) {
    echo "<div class=typ>";
    echo full_name($typ);
    echo "<br>";
    echo "<div class=tabelle>";
    tabelle_flasche($typ);
    echo "</div>";
    echo "</div>";
}
            ?>
        </div>
    </body>
</html>
