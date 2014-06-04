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
        <form class="table_row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="umsatz">
        <input type="date" name="u_datum" >
        <input type="number" step="any" name="u_fr" >
<input type="number" step="any" name="u_halb" >
<input type="number" step="any" name="u_sonst" >
         <input type="number" step="any" name="u_gz" >
         <input type="submit" name="save">
     </form>
                <ul class="lager_row">
                <li>Datum</li>
                <li>Umsatz<br>berechnet</li>
                <li>Frei Getränke</li>
                <li>Halbe Getränke</li>
                <li>Sonstiges</li>
                <li>Gezählter Umsatz</li>
                <li>Trinkgeld</li>
            </ul>
        <?php foreach (umsatz() as $row) { ?>
<ul class="lager_row">
                <li><?php echo date('d/m', strtotime($row['datum']));?></li>
                <li><?php echo $row['umsatz_br'];?> €</li>
                <li><?php echo $row['frei'];?> €</li>
                <li><?php echo $row['rabatt'];?> €</li>
                <li><?php echo $row['sonst'];?> €</li>
                <li><?php echo $row['umsatz_gz'];?> €</li>
                <li><?php echo $row['trinkgeld'] ;?> €</li>
            </ul>
                  <?php  } ?>
    </div>
</body>
</html>
