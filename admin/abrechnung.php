<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=850px">
    <title>Abrechnung</title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
    <?php if (isset($_POST['save_va'])) { new_va(date('Y-m-d', strtotime($_POST['datum'])),$_POST['name']);} ?>
</head>

<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <div id="umsatz_panel">
        <div id="va_panel">
           <ul class="va_row">
            <li class="va_datum">Datum</li>
            <li class="va_name">Name</li>
            <li class="va_umsatz">Umsatz</li>

        </ul> 
        <?php foreach (all_va() as $key => $value) { ?>
        <ul class="va_row">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                            <input type="hidden" name=datum value="<?php echo $value['datum']; ?>">
            <li class="va_datum"><?php echo date('d.m.y', strtotime($value['datum'])); ?></li>
            <li class="va_name"><?php echo $value['name']; ?></li>
            <li class="va_umsatz"><?php echo umsatz_berechnen($value['datum'])." €";?></li>
                            <input type=submit name="save_datum" value="Abrechnen">
            
                        </form>
        </ul> 
        <?php } ?>
        <form class="va_row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="new">
            <input class="va_datum" type="date" name="datum" >
            <input class="va_name" type="text" name="name" >
            <input type="submit" name="save_va" form="new">
        </form>
    </div>
            <br>
                <ul class="umsatz_row" id="legende">
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
                    <input type="text" name="datum" value="<?php echo date('d.m.Y', strtotime($_POST['datum']));?>" readonly >
                    <input type="number" name="u_br" value="<?php echo umsatz_berechnen(date('Y-m-d',strtotime($_POST['datum'])));?>" readonly>
                    <input type="number" step="any" name="u_fr" >
                    <input type="number" step="any" name="u_halb" >
                    <input type="number" step="any" name="u_sonst" >
                    <input type="number" step="any" name="u_gz" >
                    <input type="number" step="any" name="trinkgeld" disabled >
                    <input type="submit" name="save">
                </form>
                <?php }?>
                <?php if(isset($_POST['save'])){
                    add_row_umsatz(date('Y-m-d',strtotime($_POST['datum'])));
                    umsatz_speichern(date('Y-m-d',strtotime($_POST['datum'])),$_POST['u_br'],$_POST['u_fr'],$_POST['u_halb'],$_POST['u_sonst'],$_POST['u_gz']);
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
                    <form method="post" target="_blank" action="abrechnungprint.php">
                        <input type="hidden" name="datum" value="<?php echo $row['datum'];?>">


                        <input type="submit" name="print" value="Print">

                    </form>
                </ul>
                <?php  } ?>
            </div>
        </div>
    </body>
    </html>
