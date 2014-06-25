<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Abrechnung <?php echo date('d.m.Y',strtotime($_POST['datum'])); ?></title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/print.css">
</head>

<body>
	<div id="header" >
        <ul>
            <li>Datum: <?php echo date('d.m.Y',strtotime($_POST['datum'])); ?></li>
            <li>Verastaltung:</li>
        </ul>
    </div>
    <br>
    <hr>
    <div class="table">
        <ul class="legend">
            <li class="name" >Artikel</li>
            <li>V</li>
            <li>TU</li>
        </ul>
        <?php 
        $umsatz_gesamt="0";
        foreach (waren(kasten) as $typ) {

            echo "<ul><li class=name>".full_name($typ)."</li>";
            $sql = "SELECT * FROM $typ WHERE datum = '".$_POST['datum']."'";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($result);
            $umsatz_gesamt = $umsatz_gesamt+$row['umsatz'];
            echo "<li>".$row['verbrauch']."</li>";
            echo "<li>".round($row['umsatz'],2)." €</li></ul>";

        }
        
        ?>
    </div>
    <div class="table">
        <ul class="legend">
            <li class="name" >Artikel</li>
            <li>V</li>
            <li>TU</li>
        </ul>
        <?php
        foreach (waren(flasche) as $typ) {
            if ($typ == "barbara" or $typ == "mexi" or $typ == "hasel"){}
              else {
                echo "<ul><li class=name>".full_name($typ)."</li>";
                $sql = "SELECT * FROM $typ WHERE datum = '".$_POST['datum']."'";
                $result = mysqli_query($con,$sql);
                $row = mysqli_fetch_array($result);
                $umsatz_gesamt = $umsatz_gesamt+$row['umsatz'];
                echo "<li>".$row['verbrauch']."</li>";
                echo "<li>".round($row['umsatz'],2)." €</li></ul>";

            }
        }
        ?>
    </div>
    
    <div id="TU">Tagesumsatz gesamt: <?php echo $umsatz_gesamt." €";?></div>
</body>
</html>