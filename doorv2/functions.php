<?php
$con = mysqli_connect(localhost,user,scandale,Lager);

// set vars
$debug="";
$id="";
$idErr="";
$exist="";
// functions
function test_input ($data) {
	$data  = trim($data);
	$data  = stripslashes($data);
	$data  = htmlspecialchars($data);
	return $data;
}
function select_row ($data) {
	global $con;
	$sql   = "SELECT * FROM members WHERE id =".$data."";
    $result = mysqli_query($con,$sql);
    if (mysqli_fetch_row($result)) { $exist=true; }
    else { $exist=false; }
    return $exist;
}

function door_check ($data) {
    global $exist,$row,$count;
    select_row($data);
    if  (!$exist)   {
        echo "<img src=\"../media/error.png\" >";
    }
    elseif  ($exist)    {
        echo $row['name'];
        echo "<br>";
        for ($x=1; $x<=$row['ratten']; $x++)    {
            echo "<img class=\"ratte\" src=\"../media/ratte.png\">";
        }
    }
}
function add_lastvisit ($data) {
	$db    = new MyDB();
    $time  = time() - (12 * 60 * 60);
	$date  = date("d.m.y", $time);
	$sql   =<<<SQL
    UPDATE members set lastvisit="$date" where "id"=$data;
SQL;
	$ret   = $db->exec($sql);
    $db->close();
}
function visit_counter ($data) {
    global $row;
    select_row($data);
	$count = $row['visit_count'];
	$count = $count+1;
	$db    = new MyDB();
	$write =<<<SQL
	UPDATE members SET visit_count="$count" WHERE "id"=$data;
SQL;
	$ret   = $db->exec($write);
    $db->close();
}
?>
