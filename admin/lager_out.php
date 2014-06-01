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
        <div class="bestand">
            <?php foreach (waren(kasten) as $typ) { ?>
                <a href="#<?php echo $typ; ?>" ><?php bestand($typ);?></a>
            <?php } foreach (waren(flasche) as $typ) { ?>
                <a href="#<?php echo $typ; ?>" ><?php bestand($typ);?></a>
            <?php } ?>
        </div>
        <?php foreach (waren(kasten) as $typ) {
            echo "<div class=typ id=$typ >";
            echo full_name($typ);
            echo "<br>";
            echo "<div class=tabelle>";
            tabelle_kasten($typ);
            echo "</div>";
            echo "</div>";
        }
        foreach (waren(flasche) as $typ) {
            echo "<div class=typ id=$typ >";
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
