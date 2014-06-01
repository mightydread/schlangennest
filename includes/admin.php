<?php
$con_lager = mysqli_connect(localhost,user,scandale,Lager);
$con_members = mysqli_connect(localhost,user,scandale,members);
mysqli_set_charset($con_lager, 'utf8');
mysqli_set_charset($con_members, 'utf8');
// define vars
$email_array=array();
//
// Member List Functions
//
function select_row ($data) {
    global $con_members;
    $sql   = "SELECT * FROM members WHERE id=".$data."";
    $result = mysqli_query($con_members,$sql);
    return mysqli_fetch_array($result,MYSQLI_ASSOC);
}
function check_for_row ($data) {
    global $con_members,$exist;
    $sql   = "SELECT * FROM members WHERE id=".$data." LIMIT 1";
    $result = mysqli_query($con_members,$sql);
    if (mysqli_fetch_row($result)) { $exist=true; }
    else { $exist=false; }
    return $exist;
}
function create_id_array($data,$column) {
    global $con_members;
    $search_term_esc = AddSlashes($data);
    $sql="SELECT id FROM members WHERE $column LIKE '%$search_term_esc%' ORDER BY id";
    $result = mysqli_query($con_members,$sql);
    $all_id = array();
    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $all_id=array_merge_recursive($all_id,$row);
    }
    $all_id=$all_id['id'];
    return $all_id;
}
function update_db ($data1,$data2,$data3) {
    global $con_members;
    $sql   ="UPDATE members SET ".$data3."='".$data2."' WHERE id =".$data1."";
    mysqli_query($con_members,$sql);
}
function add_to_db ($nummer,$name,$ratten)  {
    global $con_members;
    $sql   ="INSERT INTO members (id,name,ratten) VALUES (".$nummer.",'".$name."',".$ratten.")";
    mysqli_query($con_members,$sql);
}
//
// Email functions
//
function email_array ($cond) {
    global $con_members;
    if ($cond == all) {$sql="SELECT email FROM members ORDER BY id";}
    else   {$sql= "SELECT email FROM members WHERE ".$cond."=1 ORDER BY id";}
    $result = mysqli_query($con_members,$sql);
    $email_temp = array();
    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $email_temp=array_merge_recursive($email_temp,$row);
    }
    $email_temp = $email_temp['email'];
    return $email_temp;
}
//
// Lager Functions
//
function full_name ($typ) {
    global $con_lager;
    $sql= "SELECT full_name FROM namen WHERE db_name = '".$typ."'";
    $array = mysqli_fetch_array(mysqli_query($con_lager,$sql));
    return $array['full_name'];
}
function waren ($art) {
    global $con_lager;
    $sql = "SELECT db_name FROM namen WHERE art = '".$art."'";
    $result = mysqli_query($con_lager,$sql);
    $array = array();
    while  ($row = mysqli_fetch_array($result,MYSQLI_NUM)) { $array[] = $row['0']; }
    return $array;
}
function tabelle_kasten ($typ) {
    global $con_lager;
    $sql = "SELECT * FROM ".$typ."";
    $result = mysqli_query($con_lager,$sql);
    echo "<div class=tabelle_row>";
    echo "<div class=tabcell_number>";
    echo "Datum";
    echo "</div>";
    echo "<div class=tabcell_head>";
    echo "<div class=tabcell_big>";
    echo "Anfang";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Kasten";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Flaschen";
    echo "</div>";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Zugang";
    echo "</div>";
    echo "<div class=tabcell_head>";
    echo "<div class=tabcell_big>";
    echo "Ende";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Kasten";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Flaschen";
    echo "</div>";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Abgang";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Verbrauch";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Umsatz";
    echo "</div>";
    echo "</div>";
    echo "<br>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<div class=tabelle_row>";
        echo "<div class=tabcell_number>";
        echo date('d/m', strtotime($row['datum']));
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['anfang_kasten'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['anfang_flaschen'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['zugang'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['ende_kasten'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['ende_flaschen'];
        echo "</div>";;
        echo "<div class=tabcell_number>";
        echo $row['abgang'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['verbrauch'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['umsatz']." &euro;";
        echo "</div>";
        echo "</div>";
    }
}
function tabelle_flasche ($typ) {
    global $con_lager;
    $sql = "SELECT * FROM ".$typ."";
    $result = mysqli_query($con_lager,$sql);
    echo "<div class=tabelle_row>";
    echo "<div class=tabcell_number>";
    echo "Datum";
    echo "</div>";
    echo "<div class=tabcell_head>";
    echo "<div class=tabcell_big>";
    echo "Anfang";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Flasche";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Anbruch";
    echo "</div>";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Zugang";
    echo "</div>";
    echo "<div class=tabcell_head>";
    echo "<div class=tabcell_big>";
    echo "Ende";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Flasche";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Anbruch";
    echo "</div>";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Abgang";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Verbrauch";
    echo "</div>";
    echo "<div class=tabcell_number>";
    echo "Umsatz";
    echo "</div>";
    echo "</div>";
    echo "<br>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<div class=tabelle_row>";
        echo "<div class=tabcell_number>";
        echo date('d/m', strtotime($row['datum']));
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['anfang_kasten'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['anfang_flaschen'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['zugang'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['ende_kasten'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['ende_flaschen'];
        echo "</div>";;
        echo "<div class=tabcell_number>";
        echo $row['abgang'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['verbrauch'];
        echo "</div>";
        echo "<div class=tabcell_number>";
        echo $row['umsatz']." &euro;";
        echo "</div>";
        echo "</div>";
    }
}
function bestand ($typ) {
    global $con_lager;
    $sql = "SELECT * FROM ".$typ." ORDER BY datum DESC LIMIT 1";
    $result = mysqli_query($con_lager,$sql);
    $row = mysqli_fetch_array($result);
    //    print_r($row);
    if ($row['ende_kasten'] == 0 and $row['ende_flaschen'] == 0) { echo full_name($typ).": ".$row['anfang_kasten']."/".$row['anfang_flaschen']." "; }
    else { echo full_name($typ).": ".$row['ende_kasten']."/".$row['ende_flaschen']." ";}
}
?>
