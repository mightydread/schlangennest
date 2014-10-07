<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
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
        <?php foreach (waren() as $typ) { ?>
        <div class="lager_panel" id="<?php echo $typ;?>">
            <h1><?php echo full_name($typ);?></h1>
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
            <?php foreach (tabelle($typ) as $row) { ?>
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
        <?php } ?>
    </div>
</body>
</html>
