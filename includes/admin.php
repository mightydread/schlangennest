<?php
$con = mysqli_connect(localhost,user,scandale,Lager);
// define vars
$all_id = array();
$email_array    = array();
$email_array_all    = array();
$cond="";
class MyDB extends SQLite3 {
    function __construct() {
        $this->open(__DIR__.'/../db/scandale.db');
    }
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
function create_id_array($data) {
    global $all_id;
    $db = new MyDB();
    if  ($data==3)  {
        $cond="ratten=3";
    }
    elseif  ($data==2)  {
        $cond="ratten=2";
    }
    elseif  ($data==1)  {
        $cond="ratten=1";
    }
    $sql=<<<SQL
        SELECT id FROM members WHERE $cond ORDER BY id;
SQL;
    $ret = $db->query($sql);
    while ($row=$ret->fetchArray(SQLITE3_ASSOC)) {
        $all_id=array_merge_recursive($all_id,$row);
    }
    $all_id=$all_id['id'];
    $db->close();
}
function create_edit_table ($input) {
    global $all_id,$row;
    create_id_array($input);
    echo    "<div id=legend>";
    echo    "<div class=nummer><img alt=ID src=\"/media/id.png\"></div>";
    echo    "<div class=name><img alt=NAME src=\"/media/name.png\"></div>";
    echo    "<div class=email><img alt=EMAIL src=\"/media/email_transp.png\"></div>";
    echo    "<div class=telefon><img alt=TELEFON src=\"/media/tel.png\"></div>";
    echo    "<div class=boxes>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "</div>";
    echo    "<div class=save></div>";
    echo    "<div class=lastvisit><img alt=DATUM src=\"/media/clock.png\"></div>";
    echo    "<div class=visit_count><img alt=BESUCHE src=\"/media/times.png\"></div>";
    echo    "</div>";
    foreach ($all_id as $data) {
        select_row($data);
        echo    "<form method=post class=table_row action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" id=".$data.">";
        echo    "<input type=hidden name=ratten value=".$row['ratten'].">";
        echo    "<input name=\"id\" value=".$row['id']." type=hidden>";
        echo    "<div class=nummer>".$row['id']."</div>";
        echo    "<div class=name><input name=\"name\" value=\"" . $row['name'] . "\" type=text></div>";
        echo    "<div class=email><input name=\"email\" value=\"" . $row['email'] . "\" type=text></div>";
        echo    "<div class=telefon><input name=\"telefon\" value=\"" . $row['telefon'] . "\" type=text></div>";
        echo    "<div class=boxes>";
        echo    "<input type=hidden name=electro value=0>";
        echo    "<div class=checkbox><input name=\"electro\" value=1 type=\"checkbox\""; if($row['electro']==1) {echo "checked";} echo "/>elektro</div>";
        echo    "<input type=hidden name=alternativ value=0>";
        echo    "<div class=checkbox><input name=\"alternativ\" value=1 type=\"checkbox\""; if($row['alternativ']==1) {echo "checked";} echo ">alternativ</div>";
        echo    "<input type=hidden name=hiphop value=0>";
        echo    "<div class=checkbox><input name=\"hiphop\" value=1 type=\"checkbox\""; if($row['hiphop']==1) {echo "checked";} echo ">hiphop</div>";
        echo    "<input type=hidden name=live value=0>";
        echo    "<div class=checkbox><input name=\"live\" value=1 type=\"checkbox\""; if($row['live']==1) {echo "checked";} echo ">live</div>";
        echo    "<input type=hidden name=good_taste value=0>";
        echo    "<div class=checkbox><input name=\"good_taste\" value=1 type=\"checkbox\""; if($row['good_taste']==1) {echo "checked";} echo ">goodtaste</div>";
        echo    "<input type=hidden name=quiz value=0>";
        echo    "<div class=checkbox><input name=\"quiz\" value=1 type=\"checkbox\""; if($row['quiz']==1) {echo "checked";} echo ">quiz</div>";
        echo    "<input type=hidden name=studenten value=0>";
        echo    "<div class=checkbox><input name=\"studenten\" value=1 type=\"checkbox\""; if($row['studenten']==1) {echo "checked";} echo ">studenten</div>";
        echo    "<input type=hidden name=kleinkunst value=0>";
        echo    "<div class=checkbox><input name=\"kleinkunst\" value=1 type=\"checkbox\""; if($row['kleinkunst']==1) {echo "checked";} echo ">kleinkunst</div>";
        echo    "</div>";
        echo    "<div class=save><input name=save value=save type=image form=".$data." src=\"/media/save.png\"></div>";
        echo    "<div class=lastvisit>". $row['lastvisit'] . "</div>";
        echo    "<div class=visit_count>" . $row['visit_count'] . "</div>";
        echo    "</form>";
//        echo    "<br>";
    }
    echo    "<form method=post class=table_row action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" id=new>";
    echo    "<input type=hidden name=ratten value=".$_POST['ratten'].">";
    echo    "<div class=nummer><input name=\"id\" type=text></div>";
    echo    "<div class=name><input name=\"name\" type=text></div>";
    echo    "<div class=email></div>";
    echo    "<div class=telefon></div>";
    echo    "<div class=boxes>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "<div class=checkbox></div>";
    echo    "</div>";
    echo    "<div class=save><input name=new value=NEU type=image form=new src=\"/media/new.png\"></div>";
    echo    "<div class=lastvisit></div>";
    echo    "<div class=visit_count></div>";
    echo    "</form>";
}
function update_db ($data1,$data2,$data3) {
    $db    = new MyDB();
    $sql   =<<<SQL
        UPDATE members set $data3="$data2" where "id"=$data1;
SQL;
    $ret   = $db->exec($sql);
    $db->close();
}
function add_to_db ($nummer,$name,$ratten)  {
    $db    = new MyDB();
    $sql   =<<<SQL
        INSERT INTO members (id,name,ratten) VALUES ("$nummer","$name","$ratten");
SQL;
    $ret   = $db->exec($sql);
    $db->close();
}
function edit_email_array($cond) {
    global $email_array;
    $db = new MyDB();
    $sql=<<<SQL
        SELECT email FROM members WHERE $cond=1 ORDER BY id;
SQL;
    $ret = $db->query($sql);
    $email_temp = array();
    while ($row=$ret->fetchArray(SQLITE3_ASSOC)) {
        $email_temp=array_merge_recursive($email_temp,$row);
    }
    $email_temp    = array_diff($email_temp['email'],$email_array);
    $db->close();
    $email_array    = array_merge($email_array,$email_temp);
}
function email_array() {
    global $email_array_all;
    $db = new MyDB();
    $sql=<<<SQL
        SELECT email FROM members ORDER BY id;
SQL;
    $ret = $db->query($sql);
    while ($row=$ret->fetchArray(SQLITE3_ASSOC)) {
        $email_array_all=array_merge_recursive($email_array_all,$row);
    }
    $email_array_all    = $email_array_all['email'];
    $db->close();
}
function create_email_form ()   {
    echo    "<form method=post class=table_row action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" id=email>";
    echo    "<div class=email_checkbox><input name=all value=1 type=checkbox>all</div>";
    echo    "<div class=email_checkbox><input name=electro value=1 type=checkbox>elektro</div>";
    echo    "<div class=email_checkbox><input name=alternativ value=1 type=checkbox>alternativ</div>";
    echo    "<div class=email_checkbox><input name=hiphop value=1 type=checkbox>hiphop</div>";
    echo    "<div class=email_checkbox><input name=live value=1 type=checkbox>live</div>";
    echo    "<div class=email_checkbox><input name=good_taste value=1 type=checkbox>goodtaste</div>";
    echo    "<div class=email_checkbox><input name=quiz value=1 type=checkbox>quiz</div>";
    echo    "<div class=email_checkbox><input name=studenten value=1 type=checkbox>studenten</div>";
    echo    "<div class=email_checkbox><input name=kleinkunst value=1 type=checkbox>kleinkunst</div>";
    echo    "<div class=save><input name=save value=save type=image form=email src=\"/media/save.png\"></div>";
}

function full_name ($typ) {
    global $con;
    $sql= "SELECT full_name FROM namen WHERE db_name = '".$typ."'";
    $array = mysqli_fetch_array(mysqli_query($con,$sql));
    return $array['full_name'];
}
function waren ($typ) {
    global $con;
    $sql = "SELECT db_name FROM namen WHERE typ = '".$typ."'";
    $result = mysqli_query($con,$sql);
    $array = array();
    while  ($row = mysqli_fetch_array($result,MYSQLI_NUM)) { $array[] = $row['0']; }
    return $array;
}
function tabelle_kasten ($typ) {
    global $con;
    $sql = "SELECT * FROM ".$typ."";
    $result = mysqli_query($con,$sql);
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
    global $con;
    $sql = "SELECT * FROM ".$typ."";
    $result = mysqli_query($con,$sql);
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
?>
