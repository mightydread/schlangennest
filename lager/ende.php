<?php session_start(); ?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
    <title>Lager</title>
    <link rel="stylesheet" type="text/css" href="../media/global.css">
    <link rel="stylesheet" type="text/css" href="../media/lager.css">
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/lager.php' ?>
</head>

<body>
    <div>
        <?php if (isset($_GET[ 'restart'])) { session_destroy(); } ?>
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <input type="submit" name="restart" value="Restart">
        </form>
    </div>
    <div class="wrap">
        <div class=legend_row>
            <div class=name>Kastenware</div>
            <div class=anzahl>kasten</div>
            <div class=anzahl>flaschen</div>
            <div class=anzahl>abgang</div>
            <div class=save></div>
        </div>
        <?php foreach (waren(kasten) as $typ) { ende_row($typ,kasten); } ?>
        <div class=legend_row>
            <div class=name>Flaschenware</div>
            <div class=anzahl>volle Falschen</div>
            <div class=anzahl>anbruch</div>
            <div class=anzahl>abgang</div>
            <div class=save></div>
        </div>
        <?php foreach (waren(flasche) as $typ) { ende_row($typ,flasche); } ?>
    </div>

</body>

</html>
