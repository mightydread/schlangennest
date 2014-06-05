<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Lager Ausgabe</title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
</head>

<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <?php print_r($_POST);?>
        <form class="umsatz_row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <input type="date" name=datum value="D.M.YYYY">
            <input type=submit name="save_datum">
        </form>
        <div id="umsatz_panel">
            <ul class="umsatz_row">
                <li>Datum</li>
                <li>Umsatz<br>berechnet</li>
                <li>Frei Getränke</li>
                <li>Halbe Getränke</li>
                <li>Sonstiges</li>
                <li>Gezählter Umsatz</li>
                <li>Trinkgeld</li>
            </ul>
            <?php if (isset($_POST['save_datum'])){ ?>
            <form class="umsatz_row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="umsatz">
                <input type="date" name="u_datum" value="<?php echo date('d.m.Y', strtotime($_POST['datum']));?>" readonly >
                <input type="number" name="u_br" value="<?php echo umsatz_berechnen(date('Y-m-d',strtotime($_POST['datum'])));?>" readonly>
                <input type="number" step="any" name="u_fr" >
                <input type="number" step="any" name="u_halb" >
                <input type="number" step="any" name="u_sonst" >
                <input type="number" step="any" name="u_gz" >
                <input type="submit" name="save">
            </form>
            <?php }?>
            <?php if(isset($_POST['save'])){
                add_row_umsatz(date('Y-m-d',strtotime($_POST['u_datum'])));
                umsatz_speichern(date('Y-m-d',strtotime($_POST['u_datum'])),$_POST['u_br'],$_POST['u_fr'],$_POST['u_halb'],$_POST['u_sonst'],$_POST['u_gz']);
                }?>
            <?php foreach (umsatz() as $row) { ?>
            <ul class="umsatz_row">
                <li><?php echo date('d.m', strtotime($row['datum']));?></li>
                <li><?php echo $row['umsatz_br'];?> €</li>
                <li><?php echo $row['frei'];?> €</li>
                <li><?php echo $row['rabatt'];?> €</li>
                <li><?php echo $row['sonst'];?> €</li>
                <li><?php echo $row['umsatz_gz'];?> €</li>
                <li><?php echo $row['trinkgeld'] ;?> €</li>
            </ul>
            <?php  } ?>
        </div>
    </div>
</body>
</html>
