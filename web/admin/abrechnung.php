<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=830px">
    <title>Abrechnung</title>
    <?php require 'admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
    <?php if (isset($_POST['save_va'])) { new_va(date('Y-m-d', strtotime($_POST['datum'])),$_POST['name']);} ?>
</head>

<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <div id="va_panel">
           <ul>
            <li >Datum</li>
            <li class="va_name">Name</li>
            <li >Umsatz</li>
        </ul> 
        <?php foreach (all_va() as $key => $value) {
            $sql2 = "SELECT 1 FROM abrechnung WHERE datum ='".$value['datum']."' LIMIT 1";
            $result2 = mysqli_query($con,$sql2);
            if (mysqli_fetch_row($result2)) { 
            } else { ?>
            <ul>
                <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#umsatz" >
                    <input type="hidden" name=datum value="<?php echo $value['datum']; ?>">
                    <li><?php echo date('d.m.y', strtotime($value['datum'])); ?></li>
                    <li class="va_name"><?php echo $value['name']; ?></li>
                    <li><?php echo umsatz_berechnen($value['datum'])." €";?></li>
                    <input type=submit name="save_datum" value="Abrechnen">
                </form>
            </ul> 
            <?php } }?>
            <ul>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="new">
                    <li><input type="date" name="datum" ></li>
                    <li class="va_name"><input type="text" name="name" ></li>
                    <li>-</li>
                    <input type="submit" name="save_va" form="new" value="Hinzufügen">
                </form>
            </ul>
        </div>
        <br>
        <div id="month_select">
            <ul>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=6&year=14">Juni 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=7&year=14">Juli 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=8&year=14">August 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=9&year=14">September 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=10&year=14">Oktober 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=11&year=14">November 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=12&year=14">Dezember 14</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=1&year=15">Januar 15</a></li>
            <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?month=2&year=15">Februar 15</a></li>
            </ul>
        </div>
        <br>
        <div id="umsatz_panel">
            <ul>
                <li>Datum</li>
                <li>Umsatz ber.</li>
                <li>Frei Getränke</li>
                <li>1/2 Getränke</li>
                <li>Sonstiges</li>
                <li>Umsatz gez.</li>
                <li>Trinkgeld</li>
            </ul>
            <?php if (isset($_POST['save_datum'])){ ?>
            <ul>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="umsatz">
                    <li><input type="text" name="datum" value="<?php echo date('d.m.Y', strtotime($_POST['datum']));?>" readonly ></li>
                    <li><input type="number" name="u_br" value="<?php echo umsatz_berechnen(date('Y-m-d',strtotime($_POST['datum'])));?>" readonly></li>
                    <li><input type="number" step="any" name="u_fr" ></li>
                    <li><input type="number" step="any" name="u_halb" ></li>
                    <li><input type="number" step="any" name="u_sonst" ></li>
                    <li><input type="number" step="any" name="u_gz" ></li>
                    <li><input type="number" step="any" name="trinkgeld" disabled ></li>
                    <input type="submit" name="save" value="Speichern">
                </form>
            </ul>
            <?php }?>
            <?php if(isset($_POST['save'])){
                add_row_umsatz(date('Y-m-d',strtotime($_POST['datum'])));
                umsatz_speichern(date('Y-m-d',strtotime($_POST['datum'])),$_POST['u_br'],$_POST['u_fr'],$_POST['u_halb'],$_POST['u_sonst'],$_POST['u_gz']);
            }?>
            <?php if (isset($_GET['month'])) {
            foreach (umsatz($_GET['month'],$_GET['year']) as $row) { ?>
            <ul>
                <li><?php echo date('d.m', strtotime($row['datum']));?></li>
                <li><?php echo $row['umsatz_br'];?> €</li>
                <li><?php echo $row['frei'];?> €</li>
                <li><?php echo $row['rabatt'];?> €</li>
                <li><?php echo $row['sonst'];?> €</li>
                <li><?php echo $row['umsatz_gz'];?> €</li>
                <li><?php echo $row['trinkgeld'] ;?> €</li>
                <li class="print"><form method="post" target="_blank" action="abrechnungprint.php">
                    <input type="hidden" name="datum" value="<?php echo $row['datum'];?>">
                    <input type="submit" name="print" value="Drucken">
                    <input class=checkbox id="clean" name=clean value=1 type=checkbox>
                </form></li>
            </ul>
            <?php  } }?>
        </div>
    </div>
</body>
</html>
