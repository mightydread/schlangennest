<?php
require 'admin.php';
require 'lager.php';
$message="LOG:".PHP_EOL;
$recipient="mightydreadmario@gmail.com";
$headers = "From: bob@wtf-no.com";
$datum=get_date();
print_r(get_va($datum));
$subject="Automatische Inventur Erfolgreich für ".get_va($datum)['name'];
if ( get_va($datum) != "false" ) {
	foreach (waren() as $typ) {
		$sql="SELECT 1 FROM ".$typ." WHERE datum ='".$datum."'";
		$result = mysqli_query($con,$sql);
		if (mysqli_fetch_row($result)) { 
	
		}
		else {
			add_row($typ,$datum);
			$sql = "UPDATE ".$typ." SET i_g='".letzte_inv($typ,$datum)['i_g']."', i_k='".letzte_inv($typ,$datum)['i_k']."' WHERE datum='".$datum."'";
			if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
			$message = $message.$sql.PHP_EOL;
		}
	}
	echo $message;
	mail($recipient,$subject,$message,$headers);
}
else {
	echo "false";
}	
