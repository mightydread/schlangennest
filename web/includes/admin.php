<?php
require 'db.php';
mysqli_set_charset($con, 'utf8');
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
    $a=array();
    $sql = "SELECT * FROM namen WHERE db_name = '".$typ."'";
    $result = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {$a['st']=$row['einheit'];$a['art']=$row['art'];$a['preis']=$row['preis'];}
    return $a;
}
function tabelle ($typ,$month,$year) {
    global $con;
    $from=date("Y-m-d",strtotime("$year-$month-01"));
    if ($month=="12") {  $to=date("Y-m-d",strtotime(($year+1)."-01-01"));}
    else { $to=date("Y-m-d",strtotime("$year-".($month+1)."-01"));}
    $sql = "SELECT * FROM ".$typ." WHERE datum BETWEEN '".$from."' AND '".$to."'";
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
    echo full_name($typ).": ".$row['i_g']." | ".$row['i_k'];
}

//
//Veranstaltung
//
function all_va ($foo="bar") {
    global $con;
    $temp=array();
    $sql = "SELECT * FROM va ORDER BY datum ASC";
    $result = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $temp[] = $row; 
        }
        return $temp;
}
function new_va ($datum,$name) {
    global $con;
    $sql = "INSERT INTO va (datum,name) VALUES ('".$datum."','".$name."')";
    mysqli_query($con,$sql);
}
function get_va ($datum) {
    global $con;
    $sql="SELECT 1 FROM va WHERE datum ='".$datum."'";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { 
        $sql="SELECT * FROM va WHERE datum ='".$datum."'";
        $result = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            return $row; 
        }
    }
    else {
        return "false";
    }
}

