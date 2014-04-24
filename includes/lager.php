<?php
$con = mysqli_connect(localhost,user,scandale,Lager);
function get_date () {
    if (isset($_GET['datum'])) {
        return $_GET['datum'];
    }
    else {
        $time  = time() - (12 * 60 * 60);
        $datum  = date("Y-m-d", $time);
        return date("Y-m-d", strtotime($datum));
    }
}
function add_row ($typ) {
    global $con;
    $sql = "SELECT 1 FROM ".$typ." WHERE datum ='".get_date()."' LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { }
    else {
        $sql = "INSERT INTO ".$typ." (datum) VALUES ('".get_date()."')";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
}
function anfang_kisten ($typ,$anzahl) {
    global $con;
    $sql = "UPDATE ".$typ." SET anfang_kasten=".$anzahl." WHERE datum='".get_date()."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function anfang_flaschen ($typ,$anzahl) {
    global $con;
    $sql = "UPDATE ".$typ." SET anfang_flaschen=".$anzahl." WHERE datum='".get_date()."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }

}
function ende_kisten ($typ,$anzahl) {
    global $con;
    $sql = "UPDATE ".$typ." SET ende_kasten=".$anzahl." WHERE datum='".get_date()."'";
    //  echo $sql;
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function ende_flaschen ($typ,$anzahl) {
    global $con;
    $sql = "UPDATE ".$typ." SET ende_flaschen=".$anzahl." WHERE datum='".get_date()."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function verbrauch ($typ) {
    global $con;
    $sql = "SELECT * FROM ".$typ." WHERE datum='".get_date()."'";
    $result = mysqli_query($con,$sql);
    while ($row =mysqli_fetch_array($result)) {
        $verbrauch = ($row['anfang_kasten']*$row['st']+$row['anfang_flaschen']+($row['zugang']*$row['st']))-($row['ende_kasten']*$row['st']+$row['ende_flaschen']);
        $umsatz = $verbrauch*$row['preis'];
        $sql2 = "UPDATE ".$typ." SET verbrauch=".$verbrauch." WHERE datum='".get_date()."'";
        if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con)); }
        $sql2 = "UPDATE ".$typ." SET umsatz=".$umsatz." WHERE datum='".get_date()."'";
        if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con)); }
    }
}
function anfang_row ($typ) {

    if (isset($_GET[$typ])) {
        echo "<div class=lager_ok>";
        $_SESSION[$typ] = "ok";
        add_row($_GET['typ']);
        anfang_kisten($_GET['typ'],$_GET['anzahl_k']);
        anfang_flaschen($_GET['typ'],$_GET['anzahl_fl']);
        echo full_name($typ);
        echo "</div>";
    }
    elseif (isset($_SESSION[$typ])) {
        echo "<div class=lager_ok>";
        echo full_name($typ);
        echo "</div>";
    }
    else {
        echo "<form class=lager_row id=".$typ." method=get action=\"".$_SERVER["PHP_SELF"]."\" >";
        echo "<input type=hidden name=typ value=".$typ.">";
        echo "<input type=hidden name=datum value=".get_date().">";
        echo "<div class=name>".full_name($typ)."</div>";
        echo       "<div class=anzahl><input type=number step=any value=0 min=0 name=anzahl_k ></div>";
        echo       "<div class=anzahl><input type=number step=any value=0 min=0 name=anzahl_fl ></div>";
        echo "<div class=save><input type=submit form=".$typ." name=".$typ." src=\"../media/save.png\"></div>";
        echo   "</form>";

    }
}
function ende_row ($typ) {
    if (isset($_GET[$typ])) {
        echo "<div class=lager_ok>";
        $_SESSION[$typ] = "ok";
        add_row($_GET['typ']);
        ende_kisten($_GET['typ'],$_GET['anzahl_k']);
        ende_flaschen($_GET['typ'],$_GET['anzahl_fl']);
        abgang($_GET['typ'],$_GET['abgang']);
        verbrauch($_GET['typ']);
        echo full_name($typ);
        echo "</div>";
    }
    elseif (isset($_SESSION[$typ])) {
        echo "<div class=lager_ok>";
        echo full_name($typ);
        echo "</div>";
    }
    else {

        echo "<form id=".$typ." class=lager_row method=get action=\"".$_SERVER["PHP_SELF"]."\" >";
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
    if (isset($_GET[$typ])) {
        echo "<div class=lager_ok>";
        $_SESSION[$typ] = "ok";
        add_row($_GET['typ']);
        zugang($_GET['typ'],$_GET['anzahl_k']);
        echo full_name($typ);
        echo "</div>";
    }
    elseif (isset($_SESSION[$typ])) {
        echo "<div class=lager_ok>";
        echo full_name($typ);
        echo "</div>";
    }
    else {

        echo "<form id=".$typ." class=lager_row method=get action=\"".$_SERVER["PHP_SELF"]."\" >";
        echo "<input type=hidden name=typ value=".$typ.">";
        echo "<input type=hidden name=datum value=".get_date().">";
        echo "<div class=name>".full_name($typ)."</div>";
        echo "<div class=anzahl><input type=number step=any value=0 min=0 name=anzahl_k ></div>";
        echo "<div class=save><input type=submit form=".$typ." name=".$typ." src=\"../media/save.png\"></div>";
        echo "</form>";
    }
}
function zugang ($typ,$anzahl) {
    global $con;
    $sql = "UPDATE ".$typ." SET zugang=".$anzahl." WHERE datum='".get_date()."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function abgang ($typ,$anzahl) {
    global $con;
    $sql = "UPDATE ".$typ." SET abgang=".$anzahl." WHERE datum='".get_date()."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
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
function debug() {
    print_r($_SESSION);
}
?>
