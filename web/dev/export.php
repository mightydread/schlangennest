<?php
/*
* Export Mysql Data in excel or CSV format using PHP
* Downloaded from http://DevZone.co.in
*/
 date_default_timezone_set('Europe/Berlin');
// Connect to database server and select 
$con=mysqli_connect('localhost','scandale','scandale','scandale');
 
if (mysqli_connect_errno()) { 
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
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
// retrive data which you want to export
foreach (waren() as $key => $value) {
    # code...

$query = "SELECT * FROM $value";
$header = '';
$data ='';
 $myfile = fopen("export/$value.xls", "w") or die("Unable to open file!");
$export = mysqli_query($con,$query ) or die(mysqli_error($con));
 
// extract the field names for header 
 
while ($fieldinfo=mysqli_fetch_field($export))
{
	$header .= $fieldinfo->name."\t";
}
 
// export data 
while( $row = mysqli_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );
$data = str_replace( "." , "," , $data );
if ( $data == "" )
{
    $data = "\nNo Record(s) Found!\n";                        
}
fwrite($myfile,"$header\n$data");
fclose($myfile);
}
?>