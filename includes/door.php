<?php
$con_members = mysqli_connect(localhost,user,scandale,members);
// functions
function test_input ($data) {
    $data  = trim($data);
    $data  = stripslashes($data);
    $data  = htmlspecialchars($data);
    return $data;
}
function door_check ($data) {
    global $con_members,$exist;
    $sql   = "SELECT * FROM members WHERE id=".$data."";
    $result = mysqli_query($con_members,$sql);
    if (mysqli_fetch_row($result)) {
        $array = mysqli_fetch_array(mysqli_query($con_members,$sql));
        echo $array['name'];
        echo "<br>";
        for ($x=1; $x<=$array['ratten']; $x++)    {
            echo "<img class=\"ratte\" src=\"/media/images/ratte.png\">";
        }
        $exist = true;
    }
    else   {
        echo "<img src=\"../media/images/error.png\" >";
    }

}
function add_lastvisit ($data) {
    global $con_members;
    $time  = time() - (12 * 60 * 60);
    $datum  = date("Y-m-d", $time);
    $sql   = "UPDATE members SET lastvisit='".$datum."' WHERE id=".$data."";
    mysqli_query($con_members,$sql);
}
function visit_counter ($data) {
    global $con_members;
    $sql   = "SELECT * FROM members WHERE id=".$data."";
    $result = mysqli_query($con_members,$sql);
    while ($row =mysqli_fetch_array($result)) {
        $count = $row['visit_count'];
        $count = $count+1;
        $sql2 = "UPDATE members SET visit_count=".$count." WHERE id=".$data."";
        mysqli_query($con_members,$sql2);
    }
}
?>
