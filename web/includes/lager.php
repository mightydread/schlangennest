<?php
require 'db.php';
mysqli_set_charset($con, 'utf8');
function get_date () {
    if (isset($_GET['datum'])) {
        return $_GET['datum'];
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
function check_existing ($typ,$datum) {
    global $con;
    $sql="SELECT 1 FROM ".$typ." WHERE datum ='".$datum."'";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { 
        return 1;
    }
    else {
        return 0;
    }
}
function populate_session ($datum) {
    global $con;
    foreach (waren() as $typ) {
        $info[$typ] = info($typ);
        if (check_existing($typ,$datum) == "1") {
            $sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
            $result = mysqli_query($con,$sql);
            $row[$typ] = mysqli_fetch_array($result,MYSQLI_ASSOC);
        } else {
            $row[$typ] = array("i_g"=> "0","i_k"=>"0","zugang"=>"0","abgang"=>"0");
        }
        if ($row[$typ]['zugang'] != 0) { $_SESSION[$typ]['done_zg'] = "ok"; }
        if ($row[$typ]['abgang'] != 0) { $_SESSION[$typ]['done_ab'] = "ok"; }
        // if ($row[$typ]['i_g'] != 0 and $row[$typ]['i_k'] != 0) { $_SESSION[$typ]['done_inv'] = "ok"; }
        if ($row[$typ]['verbrauch'] != 0) { $_SESSION[$typ]['done_inv'] = "ok"; }
        $_SESSION[$typ]['i_g']=$row[$typ]['i_g'];
        $_SESSION[$typ]['i_k']=$row[$typ]['i_k'];
        $_SESSION[$typ]['zugang']=$row[$typ]['zugang'];
        $_SESSION[$typ]['abgang']=$row[$typ]['abgang'];
        $_SESSION[$typ]['st']=$info[$typ]['st'];
        $_SESSION[$typ]['art']=$info[$typ]['art'];
        $_SESSION[$typ]['preis']=$info[$typ]['preis'];
    }
    $_SESSION['populated']="yes";
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
function add_row_hole ($typ,$datum) {
    global $con;
    $sql = "SELECT 1 FROM hole WHERE typ ='".$typ."' LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { 
    }
    else {
        $sql = "INSERT INTO hole (last_buy,typ) VALUES ('".$datum."','".$typ."')";
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
function check_hole ($typ) {
    global $con;
    $sql = "SELECT * FROM $typ WHERE typ ='".$typ."' ORDER BY typ DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { 
        return 1;
    }
    else {
        return 0;
    }
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
        if (round($verbrauch/4,1) < $inv[1]['hole']) { 
            if ($art == "flasche") {
                $verbrauch_clean = $verbrauch-round($verbrauch/4,1);
                $hole = $inv[1]['hole']-round($verbrauch/4,1);
            } elseif ($art == "kasten") {
                $verbrauch_clean = $verbrauch-round($verbrauch/4);
                $hole = $inv[1]['hole']-round($verbrauch/4);
            }
        } elseif (round($verbrauch/4) >= $inv[1]['hole']) {
            $verbrauch_clean =$verbrauch-$inv[1]['hole'];
            $hole = $inv[1]['hole']-$inv[1]['hole'];
        }
    if ($art == "flasche") {$umsatz = ($verbrauch*($preis / $st));$umsatz_clean = ($verbrauch_clean*($preis / $st));}
    elseif ($art == "kasten") {$umsatz = ($verbrauch*$preis);$umsatz_clean = ($verbrauch_clean*$preis);}
    $sql = "UPDATE ".$typ." SET hole=".$hole.", verbrauch=".$verbrauch.", verbrauch_clean=".$verbrauch_clean.", umsatz=".round($umsatz,2).", umsatz_clean=".round($umsatz_clean,2)." WHERE datum='".$inv[1]['datum']."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
}
function inventur ($typ,$st,$i_g,$i_k,$datum) {
    global $con;
    $a = ($i_g*$st)+$i_k;
    $i_k = fmod($a,$st);
    $i_g = ($a-($i_k))/$st;
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
function hole ($typ,$st,$anzahl,$datum) {
    global $con;
    $sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
    // $array_temp=array();
    $array_temp=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $anzahl = $anzahl*$st;
    $anzahl = $anzahl + $array_temp['hole'];
    $sql = "UPDATE $typ SET hole=".$anzahl.", i_g='".$array_temp['i_g']."', i_k='".$array_temp['i_k']."' WHERE datum ='".$datum."'";
    if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
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