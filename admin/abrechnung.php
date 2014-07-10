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
        <div id="umsatz_panel">
            <div id="umsatz_kalender">
                <?php
                foreach (kalender() as $datum => $umsatz) {
                    ?>
                    <div class="button">
                        <?php 
                        echo "<div class=datum>".date('d.m.y', strtotime($datum))."</div>";
                        echo "<div class=umsatz>".$umsatz." €</div>";
                        ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                            <input type="hidden" name=datum value="<?php echo $datum ?>">
                            <input type=submit name="save_datum">
                        </form>
                    </div>
                    <?php 
                }
                ?>
            </div>
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
