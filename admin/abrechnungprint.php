<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700px">
    <title>Abrechnung <?php echo date('d.m.Y',strtotime($_POST['datum'])); ?></title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/print.css">
</head>

<body>
	<div id="header" >
        <div id="logo"><img src="/media/images/logo_scandale.png" width="230px" ></div>
        <div id="datum" >Datum: <?php echo date('d.m.Y',strtotime($_POST['datum'])); ?></div>
        <div id="comment" >Verastaltung:</div>
    </ul>
</div>
<hr>
<div class="table">
    <?php 
    $umsatz_gesamt="0";
    foreach (waren() as $typ) {
        if ($typ == "barbara" or $typ == "mexi" or $typ == "hasel" or $typ == "effect") {

        }
        else {
            $sql = "SELECT * FROM $typ WHERE datum = '".$_POST['datum']."'";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($result);
            $umsatz_gesamt = $umsatz_gesamt+$row['umsatz'];
            $array[$typ] = array( 'name' => full_name($typ), 'verbrauch' => $row['verbrauch'], 'umsatz' => round($row['umsatz'],2));
        }
    } 
    ?>
    <div id="umsatz">Tagesumsatz: <?php echo $umsatz_gesamt." €";?></div>
    <div id="detail">Details:</div>
    <table id="left" >
        <tr>
            <td class="name legend">&nbsp;Artikel</td>
            <td class="legend">Verbrauch</td>
            <td class="legend">Umsatz</td>
        </tr>
        <?php 
        foreach (waren(kasten) as $typ) {
            if ($typ == "effect") {
            }
            else {
                echo "<tr><td class=name>&nbsp;".$array[$typ]['name']."</td>";
                echo "<td>".$array[$typ]['verbrauch']." Flaschen&nbsp; </td>";
                echo "<td>".$array[$typ]['umsatz']." €&nbsp; </td></tr>";
            }
        }
        ?>
    </table>
    <table id="right">
        <tr>
            <td class="name legend" >&nbsp;Artikel</td>
            <td class="legend">Verbrauch</td>
            <td class="legend">Umsatz</td>
        </tr>
        <?php
        foreach (waren(flasche) as $typ) {
            if ($typ == "barbara" or $typ == "mexi" or $typ == "hasel"){}
              else {
                 echo "<tr><td class=name>&nbsp;".$array[$typ]['name']."</td>";
                echo "<td>".$array[$typ]['verbrauch']." Liter&nbsp; </td>";
                echo "<td>".$array[$typ]['umsatz']." €&nbsp; </td></tr>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>