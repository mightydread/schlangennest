<?php
require '../includes/db.php';
mysqli_set_charset($con, 'utf8');
 //
// Member List Functions
//
function select_row ($data) {
    global $con;
    $sql   = "SELECT * FROM members WHERE id=".$data."";
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_array($result,MYSQLI_ASSOC);
}
function check_for_row ($data) {
    global $con;
    $sql   = "SELECT * FROM members WHERE id=".$data." LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { $exist=true; }
    else { $exist=false; }
    return $exist;
}
function create_id_array($data,$column,$sort) {
    global $con;
    $search_term_esc = AddSlashes($data);
    if ($sort == "lastvisit" or $sort == "visit_count") {
        $sql="SELECT id FROM members WHERE $column LIKE '%$search_term_esc%' ORDER BY ! ASCII($sort),$sort DESC";
    }
    else {
        $sql="SELECT id FROM members WHERE $column LIKE '%$search_term_esc%' ORDER BY ! ASCII($sort),$sort";
    }
    // echo $sql;
    $result = mysqli_query($con,$sql);
    $all_id = array();
    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $all_id=array_merge_recursive($all_id,$row);
    }
    $all_id=$all_id['id'];
    return $all_id;
}
function update_db ($data1,$data2,$data3) {
    global $con;
    $sql   ="UPDATE members SET ".$data3."='".$data2."' WHERE id =".$data1."";
    mysqli_query($con,$sql);
}
function add_to_db ($nummer,$name)  {
    global $con;
    if ($nummer <= 50) { $ratten=3; }
    elseif ($nummer > 50 and $nummer <= 150) { $ratten=2; }
    elseif ($nummer > 150) { $ratten=1; }
    $sql   ="INSERT INTO members (id,name,ratten) VALUES (".$nummer.",'".$name."',".$ratten.")";
    mysqli_query($con,$sql);
}
//
// Email functions
//
function email_array ($cond) {
    global $con;
    if ($cond == all) {$sql="SELECT email FROM members ORDER BY id";}
    else   {$sql= "SELECT email FROM members WHERE ".$cond."=1 ORDER BY id";}
    $result = mysqli_query($con,$sql);
    $email_temp = array();
    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $email_temp=array_merge_recursive($email_temp,$row);
    }
    $email_temp = $email_temp['email'];
    return $email_temp;
}
function sms_array ($cond) {
    global $con;
    if ($cond == all) {$sql="SELECT telefon FROM members ORDER BY id";}
    else   {$sql= "SELECT telefon FROM members WHERE ".$cond."=1 ORDER BY id";}
    $result = mysqli_query($con,$sql);
    $sms_temp = array();
    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $sms_temp=array_merge_recursive($sms_temp,$row);
    }
    $sms_temp = $sms_temp['telefon'];
    return $sms_temp;
}
//
// Lager Functions
//
function full_name ($typ) {
    global $con;
    $sql= "SELECT full_name FROM namen WHERE db_name = '".$typ."'";
    $array = mysqli_fetch_array(mysqli_query($con,$sql));
    return $array['full_name'];
}
function waren ($art = "all") {
    global $con;
    if ($art == "all") {$sql = "SELECT db_name FROM namen";}
    else { $sql = "SELECT db_name FROM namen WHERE art = '".$art."'";}
    $result = mysqli_query($con,$sql);
    $array = array();
    while  ($row = mysqli_fetch_array($result,MYSQLI_NUM)) { $array[] = $row['0']; }
    return $array;
}
function info ($typ) {
    global $con;
    $sql = "SELECT * FROM namen WHERE db_name = '".$typ."'";
    $result = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {$a['st']=$row['einheit'];$a['art']=$row['art'];$a['preis']=$row['preis'];}
    return $a;
}
function tabelle ($typ) {
    global $con;
    $sql = "SELECT * FROM ".$typ."";
    $result = mysqli_query($con,$sql);
    $temp=array();
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $temp[]=$row;
    }
    return $temp;
}
function bestand ($typ) {
    global $con;
    $sql = "SELECT * FROM ".$typ." ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    //    print_r($row);
    echo "<nobr>".full_name($typ).":</nobr></br>".$row['i_g']."/".$row['i_k']." ";
}
// 
// Abrechnung
// 
function umsatz ($foo="bar") {
    global $con;
    $sql="SELECT * FROM abrechnung";
    $result = mysqli_query($con,$sql);
    $temp=array();
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $temp[]=$row;
    }
    return $temp;
}
function kalender ($foo="bar") {
    global $con;
    foreach (waren() as $typ) {
        if ($typ == "effect") {
        }
        $sql = "SELECT * FROM $typ";
        $result = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            if ($row['umsatz'] != 0) {
                $sql2 = "SELECT 1 FROM abrechnung WHERE datum ='".$row['datum']."' LIMIT 1";
                $result2 = mysqli_query($con,$sql2);
                if (mysqli_fetch_row($result2)) { 
                }
                else {
                    $array[$row['datum']][$typ]=$row['umsatz'];
                }
            }
        }
    }
    foreach ($array as $datum => $umsatz) {
        $array2[$datum] = 0;
        foreach ($umsatz as $typ => $value ) {
            $array2[$datum] = $array2[$datum]+$value;
        }
    }
    ksort($array2);
    return $array2;
}
function add_row_umsatz ($datum) {
    global $con;
    $sql = "SELECT 1 FROM abrechnung WHERE datum ='".$datum."' LIMIT 1";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { 
    }
    else {
        $sql = "INSERT INTO abrechnung (datum) VALUES ('".$datum."')";
        if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
    }
}
function umsatz_speichern ($datum,$umsatz_br,$frei,$rabatt,$sonst,$umsatz_gz) {
    global $con;
    $tg = ($umsatz_gz+$sonst+$rabatt+$frei)-$umsatz_br;
    $sql = "UPDATE abrechnung SET umsatz_br='".$umsatz_br."', frei='".$frei."',rabatt='".$rabatt."',sonst='".$sonst."',umsatz_gz='".$umsatz_gz."',trinkgeld='".$tg."' WHERE datum = '".$datum."' ";
    mysqli_query($con,$sql);
}

function umsatz_berechnen ($datum)  {
    global $con;
    $u_br="0";
    foreach (waren() as $typ) {
        if ($typ == "effect"){}
            $sql = "SELECT umsatz FROM $typ WHERE datum = '".$datum."'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $u_br = $u_br+$row['umsatz'];
    }
    return $u_br;
}
?>
