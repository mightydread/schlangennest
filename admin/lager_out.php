<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8mb4">
    <title>Lager Ausgabe</title>
    <?php include '../includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="../media/global.css">
    <link rel="stylesheet" type="text/css" href="../media/admin.css">
</head>

<body>
    <?php include 'navbar.php' ?>
    <div id="wrap">
    Under Development

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
