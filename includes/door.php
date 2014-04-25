<?php
class MyDB extends SQLite3 {
    function __construct() {
        $this->open(__DIR__.'/../db/scandale.db');
    }
}
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
	global $debug,$exist,$row;
	$db    = new MyDB();
	$sql   =<<<SQL
        SELECT * FROM members WHERE "id"=$data;
SQL;
    $ret   = $db->query($sql);
	$row   = $ret->fetchArray(SQLITE3_ASSOC);
	if (!$row) {
        $exist=false;
    }
	else   {
        $exist=true;
    }
    $db->close();
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
