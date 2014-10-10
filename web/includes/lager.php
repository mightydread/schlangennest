<?php
require 'db.php';
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
        // $tmparray = array();
        $sql= "SELECT full_name FROM namen WHERE db_name = '".$typ."'";
        $tmparray = mysqli_fetch_array(mysqli_query($con,$sql));
        return $tmparray['full_name'];
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
if (!function_exists('info')) {
    function info ($typ) {
        global $con;
        $a=array();
        $sql = "SELECT * FROM namen WHERE db_name = '".$typ."'";
        $result = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {$a['st']=$row['einheit'];$a['art']=$row['art'];$a['preis']=$row['preis'];}
        return $a;
    }
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
    $umsatz=0;
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
function inventur ($typ,$st,$i_g,$i_k,$datum) {
    global $con;
    $a = ($i_g*$st)+$i_k;
    $i_g = ($a-($a%$st))/$st;
    $i_k = $a%$st;
    $sql = "UPDATE ".$typ." SET i_g='".$i_g."', i_k='".$i_k."' WHERE datum='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function zugang ($typ,$anzahl,$datum) {
    global $con;
    $sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
   // $array_temp=array();
    $array_temp=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if ($array_temp['i_g'] == "0" and $array_temp['i_k'] == "0"){
        $inv[1]=letzte_inv($typ,$datum);
        $i_g=$inv[1]['i_g']+$anzahl;
        $sql = "UPDATE ".$typ." SET i_g='".$i_g."', i_k='".$inv[1]['i_k']."', zugang=".$anzahl." WHERE datum='".$datum."'";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
    else {
        $i_g=$array_temp['i_g']+$anzahl;
        $sql = "UPDATE ".$typ." SET i_g='".$i_g."', i_k='".$array_temp['i_k']."', zugang=".$anzahl." WHERE datum='".$datum."'";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
}
function abgang ($typ,$anzahl,$datum) {
    global $con;
    $sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
    // $array_temp=array();
    $array_temp=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if ($array_temp['i_g'] == "0" and $array_temp['i_k'] == "0"){
        $inv[1]=letzte_inv($typ,$datum);
        $i_k=$inv[1]['i_k']-$anzahl;
       // $verbrauch=$anzahl*info($typ)['st'];
        $sql = "UPDATE ".$typ." SET i_g=".$inv[1]['i_g'].", i_k='".$i_k."', abgang=".$anzahl." WHERE datum='".$datum."'";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
    else {
        $i_k=$array_temp['i_k']-$anzahl;
        $verbrauch=$anzahl*info($typ)['st'];
        $sql = "UPDATE ".$typ." SET i_g=".$array_temp['i_g'].", i_k='".$i_k."', verbrauch=".$verbrauch.", abgang=".$anzahl." WHERE datum='".$datum."'";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
}
function safety_check ($typ,$i_g,$i_k,$datum) {
    global $con;
    $a=letzte_inv($typ,$datum)['i_g']*info($typ)['st']+letzte_inv($typ,$datum)['i_k'];
    $b=$i_g*info($typ)['st']+$i_k;
    $sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
    $row[] = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $a= $a+($row['zugang']*info($typ)['st']);
    if ($a<$b) {
        return 0;
    }
    else {
        return 1;
    }
}