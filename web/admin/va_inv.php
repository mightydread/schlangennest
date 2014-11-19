<?php
require '../includes/admin.php';
require '../includes/lager.php';
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
			$sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
			$result = mysqli_query($con,$sql);
			$row[] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$row = $row[0];
			$sql = "UPDATE ".$typ." SET i_g='".$row['i_g']."', i_k='".$row['i_k']."' WHERE datum='".$datum."'";
			if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
			if (info($typ)['art']=="kasten") {
				$msg=full_name($typ).": ".$row['i_g']." Kasten, ".$row['i_k']." Flaschen";
			}
			else {
				$msg=full_name($typ).": ".$row['i_g']." Flaschen, ".$row['i_k']." Anbruch";
			}
			$message = $message.$msg.PHP_EOL;
		}
		else {
			add_row($typ,$datum);
			$i_g=letzte_inv($typ,$datum)['i_g'];
			$i_k=letzte_inv($typ,$datum)['i_k'];
			$sql = "UPDATE ".$typ." SET i_g='".$i_g."', i_k='".$i_k."' WHERE datum='".$datum."'";
			if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
			if (info($typ)['art']=="kasten") {
				$msg=full_name($typ).": ".$i_g." Kasten, ".$i_k." Flaschen";
			}
			else {
				$msg=full_name($typ).": ".$i_g." Flaschen, ".$i_k." Anbruch";
			}
			$message = $message.$msg.PHP_EOL;
		}
	}
	echo $message;
	mail($recipient,$subject,$message,$headers);
}
else {
	echo "false";
}	
