<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=830px">
    <title>Lager Ausgabe</title>
    <?php require 'admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
</head>
<body>

    <div id="wrap">
        <?php include 'navbar.php' ?>
        <div class="bestand">
            <?php foreach (waren() as $typ) { ?>
            <a href="#<?php echo $typ;?>" ><?php bestand($typ);?></a>
            <?php } ?>
        </div>
        <br>
        <?php foreach (waren() as $typ) { ?>
        <div class="lager_panel" id="<?php echo $typ;?>">
            <h1><?php echo full_name($typ);?></h1>
            <div id="month_select">
                <ul>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=5&year=14#<?php echo $typ;?>">Mai 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=6&year=14#<?php echo $typ;?>">Juni 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=7&year=14#<?php echo $typ;?>">Juli 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=8&year=14#<?php echo $typ;?>">August 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=9&year=14#<?php echo $typ;?>">September 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=10&year=14#<?php echo $typ;?>">Oktober 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=11&year=14#<?php echo $typ;?>">November 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=12&year=14#<?php echo $typ;?>">Dezember 14</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=1&year=15#<?php echo $typ;?>">Januar 15</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=2&year=15#<?php echo $typ;?>">Februar 15</a></li>
                </ul>
            </div>
            <?php if (isset($_GET['month'])) { ?>
            <ul class="lager_row">
                <li>Datum</li>
                <li>Zugang</li>
                <li>Abgang</li>
                <?php if (info($typ)['art'] == "kasten") { ?>
                <li>Kasten</li>
                <li>Flaschen</li>
                <?php } else { ?>
                <li>Flaschen</li>
                <li>Anbruch</li>
                <?php } ?>
                <li>Verbrauch</li>
                <li>Umsatz</li>
            </ul>
            <?php foreach (tabelle($typ,$_GET['month'],$_GET['year']) as $row) { ?>
            <ul class="lager_row">
                <li><?php echo date('d/m', strtotime($row['datum']));?></li>
                <li><?php echo $row['zugang'];?></li>
                <li><?php echo $row['abgang'];?></li>
                <li><?php echo $row['i_g'];?></li>
                <li><?php echo $row['i_k'];?></li>
                <li><?php echo $row['verbrauch'];?></li>
                <li><?php echo round($row['umsatz'],2);?> €</li>
            </ul>
            <?php } ?>
        </div>
        <?php } }?>
    </div>
</body>
</html>
