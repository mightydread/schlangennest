<?php
require 'db.php';
// functions
function test_input ($data) {
    $data  = trim($data);
    $data  = stripslashes($data);
    $data  = htmlspecialchars($data);
    return $data;
}
function get_date () {
    $time  = time() - (12 * 60 * 60);
    return date("Y-m-d", $time);
}
function door_check ($data) {
    global $con,$result;
    $sql   = "SELECT * FROM members WHERE id=".$data."";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) {
        $array = mysqli_fetch_array(mysqli_query($con,$sql));
        if ($array['lastvisit'] == get_date()) {
            $result = array("check" => "already_in");
        }
        else {
             $result = array("check" => "exist", "id" => "$data", "name" => $array['name'],"ratten" => $array['ratten']);
        }
    }
    else   {
         $result = array("check" => "invalid_number");
    }
}
function add_lastvisit ($data) {
    global $con;
    $sql   = "UPDATE members SET lastvisit='".get_date()."' WHERE id=".$data."";
    mysqli_query($con,$sql);
}
function visit_counter ($data) {
    global $con;
    $sql   = "SELECT * FROM members WHERE id=".$data."";
    $result = mysqli_query($con,$sql);
    while ($row =mysqli_fetch_array($result)) {
        $count = $row['visit_count'];
        $count = $count+1;
        $sql2 = "UPDATE members SET visit_count=".$count." WHERE id=".$data."";
        mysqli_query($con,$sql2);
    }
}
