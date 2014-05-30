<?php session_start(); ?>
<!DOCTYPE html>
<html lang="">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
        <meta name="viewport" content="width=1200px">
        <title>Lager Inventur</title>

        <link rel="stylesheet" type="text/css" href="/media/css/lager.css">
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
                <div class=anzahl>Kasten</div>
                <div class=anzahl>Flaschen</div>
                <div class=anzahl>Abgang</div>
                <div class=save></div>
            </div>
            <?php foreach (waren(kasten) as $typ) { inventur_row($typ); } ?>
            <div class=legend_row>
                <div class=name>Flaschenware</div>
                <div class=anzahl>volle Flaschen</div>
                <div class=anzahl>Anbruch</div>
                <div class=anzahl>Abgang</div>
                <div class=save></div>
            </div>
            <?php foreach (waren(flasche) as $typ) { inventur_row($typ); } ?>
        </div>
    </body>
</html>
