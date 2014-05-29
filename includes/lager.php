<?php
$con = mysqli_connect(localhost,user,scandale,Lager);
function get_date () {
    if (isset($_POST['datum'])) {
        return $_POST['datum'];
    }
    else {
        $time  = time() - (12 * 60 * 60);
        $datum  = date("Y-m-d", $time);
        return date("Y-m-d", strtotime($datum));
    }
}
function full_name ($typ) {
    global $con;
    $sql= "SELECT full_name FROM namen WHERE db_name = '".$typ."'";
    $array = mysqli_fetch_array(mysqli_query($con,$sql));
    return $array['full_name'];
}
function waren ($typ) {
    global $con;
    $sql = "SELECT db_name FROM namen WHERE typ = '".$typ."'";
    $result = mysqli_query($con,$sql);
    $array = array();
    while  ($row = mysqli_fetch_array($result,MYSQLI_NUM)) { $array[] = $row['0']; }
    return $array;
}
function add_row ($typ,$datum) {
    global $con;
    $sql = "SELECT 1 FROM ".$typ." WHERE datum ='".$datum."' LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { }
    else {
        $sql = "INSERT INTO ".$typ." (datum) VALUES ('".$datum."')";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
}
function verbrauch ($typ,$datum) {
    global $con;
    $sql = "SELECT * FROM namen WHERE db_name = '".$typ."'";
    $result = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($result)) {$einheit=$row['einheit'];$art=$row['typ'];}
    $sql = "SELECT * FROM ".$typ." WHERE datum='".$datum."'";
    $result = mysqli_query($con,$sql);
    while ($row =mysqli_fetch_array($result)) {
        $verbrauch = (($row['anfang_kasten']*$einheit)+$row['anfang_flaschen']+($row['zugang']*$einheit))-(($row['ende_kasten']*$einheit)+$row['ende_flaschen']);
        if ($art == flasche) {$umsatz = ($verbrauch*($row['preis'] / $einheit));}
        elseif ($art == kasten) {$umsatz = $verbrauch*$row['preis'];}
        $sql2 = "UPDATE ".$typ." SET verbrauch=".$verbrauch." WHERE datum='".$datum."'";
        if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con)); }
        $sql2 = "UPDATE ".$typ." SET umsatz=".$umsatz." WHERE datum='".$datum."'";
        if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con)); }
    }
}
function anfang ($typ,$kasten,$flaschen,$abgang,$datum) {
    global $con;
    $sql = "UPDATE ".$typ." SET anfang_kasten='".$kasten."', anfang_flaschen='".$flaschen."', abgang='".$abgang."' WHERE datum='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function ende ($typ,$kasten,$flaschen) {
     global $con;
     $sql = "SELECT * FROM ".$typ." ORDER BY datum DESC LIMIT 1";
     $result = mysqli_query($con,$sql);
     $row = mysqli_fetch_array($result);
//    print_r($row);
    if ($row['ende_kasten'] == 0 and $row['ende_flaschen'] == 0) {
        $sql2 = "UPDATE ".$typ." SET ende_kasten=".$kasten.", ende_flaschen=".$flaschen." WHERE datum='".$row['datum']."'";
        echo $sql2;
        if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con));}
        verbrauch($typ,$row['datum']);
    }
}
function zugang ($typ,$anzahl,$datum) {
    global $con;
    $sql = "UPDATE ".$typ." SET zugang=".$anzahl." WHERE datum='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function inventur_row ($typ) {

    if (isset($_POST[$typ])) {
        echo "<div class=lager_ok>";
        $_SESSION[$typ] = "ok";
        ende($_POST['typ'],$_POST['anzahl_k'],$_POST['anzahl_fl']);
        add_row($_POST['typ'],get_date());
        anfang($_POST['typ'],$_POST['anzahl_k'],$_POST['anzahl_fl'],$_POST['abgang'],get_date());
        echo full_name($typ);
        echo "</div>";
    }
    elseif (isset($_SESSION[$typ])) {
        echo "<div class=lager_ok>";
        echo full_name($typ);
        echo "</div>";
    }
    else {
        echo "<form class=lager_row id=".$typ." method=post action=\"".$_SERVER["PHP_SELF"]."\" >";
        echo "<input type=hidden name=typ value=".$typ.">";
        echo "<input type=hidden name=datum value=".get_date().">";
        echo "<div class=name>".full_name($typ)."</div>";
        echo       "<div class=anzahl><input type=number step=any value=0 min=0 name=anzahl_k ></div>";
        echo       "<div class=anzahl><input type=number step=any value=0 min=0 name=anzahl_fl ></div>";
        echo       "<div class=anzahl><input type=number step=any value=0 min=0 name=abgang ></div>";
        echo "<div class=save><input type=submit form=".$typ." name=".$typ." src=\"../media/save.png\"></div>";
        echo   "</form>";

    }
}
function liefer_row ($typ) {
    if (isset($_POST[$typ])) {
        echo "<div class=lager_ok>";
        $_SESSION[$typ] = "ok";
        add_row($_POST['typ']);
        zugang($_POST['typ'],$_POST['anzahl_k']);
        echo full_name($typ);
        echo "</div>";
    }
    elseif (isset($_SESSION[$typ])) {
        echo "<div class=lager_ok>";
        echo full_name($typ);
        echo "</div>";
    }
    else {

        echo "<form id=".$typ." class=lager_row method=post action=\"".$_SERVER["PHP_SELF"]."\" >";
        echo "<input type=hidden name=typ value=".$typ.">";
        echo "<input type=hidden name=datum value=".get_date().">";
        echo "<div class=name>".full_name($typ)."</div>";
        echo "<div class=anzahl><input type=number step=any value=0 min=0 name=anzahl_k ></div>";
        echo "<div class=save><input type=submit form=".$typ." name=".$typ." src=\"../media/save.png\"></div>";
        echo "</form>";
    }
}
?>
