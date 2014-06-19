<?php
require '../includes/db.php';
mysqli_set_charset($con, 'utf8');
function get_date () {
    if (isset($_POST['datum'])) {
        return $_POST['datum'];
    }
    else {
        return date("Y-m-d");
    }
}
if (!function_exists('full_name')) {
    function full_name ($typ) {
        global $con;
        $array = array();
        $sql= "SELECT full_name FROM namen WHERE db_name = '".$typ."'";
        $array = mysqli_fetch_array(mysqli_query($con,$sql));
        return $array['full_name'];
    }
}
if (!function_exists('waren')) {
    function waren ($art = "all") {
        global $con;
        if ($art == "all") {$sql = "SELECT db_name FROM namen";}
        else { $sql = "SELECT db_name FROM namen WHERE art = '".$art."'";}
        $result = mysqli_query($con,$sql);
        $array = array();
        while  ($row = mysqli_fetch_array($result,MYSQLI_NUM)) { $array[] = $row['0']; }
        return $array;
    }
}
function info ($typ) {
    global $con;
    $sql = "SELECT * FROM namen WHERE db_name = '".$typ."'";
    $result = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {$a['st']=$row['einheit'];$a['art']=$row['art'];$a['preis']=$row['preis'];}
    return $a;
}
function add_row ($typ,$datum) {
    global $con;
    $sql = "SELECT 1 FROM ".$typ." WHERE datum ='".$datum."' LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { 
    }
    else {
        $sql = "INSERT INTO ".$typ." (datum) VALUES ('".$datum."')";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
}
function letzte_inv ($typ,$datum) {
    global $con;
    $sql = "SELECT * FROM ".$typ." WHERE datum !='".$datum."' ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
    $row[] = mysqli_fetch_array($result,MYSQLI_ASSOC);
    return $row[0];
}
function verbrauch ($typ,$st,$art,$preis,$datum) {
    global $con;
    $inv[1] = letzte_inv($typ,$datum);
    $sql = "SELECT * FROM ".$typ." WHERE datum='".$datum."'";
    $result = mysqli_query($con,$sql);
    $inv[2] = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $invent = ($inv[1]['i_g']*$st)+$inv[1]['i_k'];
    
    $invent2 = ($inv[2]['i_g']*$st)+$inv[2]['i_k']-($inv[2]['zugang']*$st)+$inv[2]['abgang'];
 
    $verbrauch = $invent - $invent2;

    if ($art == "flasche") {$umsatz = ($verbrauch*($preis / $st));}
    elseif ($art == "kasten") {$umsatz = ($verbrauch*$preis);}
    $sql = "UPDATE ".$typ." SET verbrauch=".$verbrauch.", umsatz=".round($umsatz,2)." WHERE datum='".$inv[1]['datum']."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function inventur ($typ,$i_g,$i_k,$datum) {
    global $con;
    $sql = "UPDATE ".$typ." SET i_g='".$i_g."', i_k='".$i_k."' WHERE datum='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function zugang ($typ,$anzahl,$datum) {
    global $con;
    $inv[1]=letzte_inv($typ,$datum);
    $i_g=$inv[1][i_g]+$anzahl;
    $sql = "UPDATE ".$typ." SET i_g='".$i_g."', i_k='".$inv[1][i_k]."', zugang=".$anzahl." WHERE datum='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function abgang ($typ,$anzahl,$datum) {
    global $con;
    $inv[1]=letzte_inv($typ,$datum);
    $i_g=$inv[1][i_g]-$anzahl;
    $verbrauch=$anzahl*info($typ)['st'];
    $sql = "UPDATE ".$typ." SET i_g=".$i_g.", i_k='".$inv[1][i_k]."', verbrauch=".$verbrauch.", abgang=".$anzahl." WHERE datum='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
