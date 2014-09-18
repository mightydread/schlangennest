<?php
require '../includes/admin.php';
require '../includes/lager.php';
$datum = get_date();
if ( get_va($datum) != "false" ) {
	foreach (waren() as $typ) {
		$sql="SELECT 1 FROM ".$typ." WHERE datum ='".$datum."'";
		$result = mysqli_query($con,$sql);
		if (mysqli_fetch_row($result)) { 
			$sql = "SELECT * FROM ".$typ." WHERE datum ='".$datum."' ORDER BY datum DESC LIMIT 1";
			$result = mysqli_query($con,$sql);
			$row[] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$row = $row[0];
			$sql = "UPDATE ".$typ." SET i_g='".$row[i_g]."', i_k='".$row[i_k]."' WHERE datum='".$datum."'";
			echo $sql." ";
			if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
		}
		else {
			add_row($typ,$datum);
			$sql = "UPDATE ".$typ." SET i_g='".letzte_inv($typ,$datum)[i_g]."', i_k='".letzte_inv($typ,$datum)[i_k]."' WHERE datum='".$datum."'";
			echo $sql." ";
			if (!mysqli_query($con,$sql)) { die('Error: ' . mysqli_error($con)); }
		}
	}

}
else {
	echo "false";
}	

?>