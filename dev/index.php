<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" >
	<title>Development Area</title>
	<?php require '../includes/admin.php' ?>
	<?php require '../includes/door.php' ?>
	<?php require '../includes/lager.php' ?>

	<link rel="stylesheet" type="text/css" href="../media/css/admin.css">
</head>
<body>
	<?php print_r(kalender()); ?>
	Sucess!!!<br>
	<div id="wrap">
		<div id="umsatz_kalender">
			<?php
			foreach (waren() as $typ) {
				if ($typ == "effect") {
				}
				$sql = "SELECT * FROM $typ";
				$result = mysqli_query($con,$sql);
				while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					if ($row['umsatz'] != 0) {
						$array[$row['datum']][$typ]=$row['umsatz'];
					}
				}
			}
			foreach ($array as $datum => $umsatz) {
				$array[$datum]['gesamt'] = 0;
				foreach ($umsatz as $typ => $value ) {
					$array[$datum]['gesamt'] = $array[$datum]['gesamt']+$value;
				}
				?>
				<div class="button">
					<?php 
					echo date('d.m.y', strtotime($datum));
					echo "<br>";
					echo $array[$datum]['gesamt']." €";
					?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
						<input type="hidden" name=datum value="<?php echo $datum ?>">
						<input type=submit name="save_datum">
					</form>
				</div>
				<?php }

				?>

			</div>
		</div>



		<?php 

//     print_r($db_name);
//     $verbrauch=0;
//     $umsatz=0;
//     foreach (waren() as $typ) {
//         $x=0;
//         $sql="SELECT * FROM $typ";
//         $result=mysqli_query($con,$sql);
//         while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
//             $array[$typ][$x] = $row;
//             ++$x;
//         }
//         foreach (info($typ) as $key => $value) {
//             $array[$typ][$key]=$value;

//         }

//         foreach ($array[$typ] as $key => $value) {
//             if ($key == "art" or $key == "preis" or $key == "st") {

//             }
//             elseif ($array[$typ][$key]['datum'] == "2014-06-18"){
//               $sql2 = "UPDATE ".$typ." SET verbrauch= '0', umsatz='0' WHERE datum='".$array[$typ][$key]['datum']."'";
//                 // mysqli_query($con,$sql);
//                 echo $sql2;
//                 echo "<br>";
//                 if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con)); }
//                 sleep(0.5);  
//             }
//             else {
//                 print_r($value);    
//                 echo "<br>";
//                 print_r($key);
//                 echo "<br>";
//                 $y=$key+1;
//                 $invent = ($array[$typ][$key]['i_g'] * $array[$typ]['st']) + $array[$typ][$key]['i_k'];
//                 echo "invent ".$invent."<br>";
//                 $invent2 = ($array[$typ][$y]['i_g'] * $array[$typ]['st']) + $array[$typ][$y]['i_k'] - ($array[$typ][$y]['zugang'] * $array[$typ]['st']) + $array[$typ][$y]['abgang'];
//                 echo "invent2 ".$invent2."<br>";
//                 $verbrauch = $invent - $invent2;
// echo "verbrauch ".$verbrauch."<br>";
//                 if ($array[$typ]['art'] == "flasche") {$umsatz = ($verbrauch*($array[$typ]['preis'] / $array[$typ]['st']));}
//                 elseif ($array[$typ]['art'] == "kasten") {$umsatz = ($verbrauch*$array[$typ]['preis']);}
//                 echo "umsatz ".$umsatz."<br>";
//                 $sql2 = "UPDATE ".$typ." SET verbrauch='".$verbrauch."', umsatz='".round($umsatz,2)."' WHERE datum='".$array[$typ][$key]['datum']."'";
//                 // mysqli_query($con,$sql);
//                 echo $sql2;
//                 echo "<br>";
//                 if (!mysqli_query($con,$sql2)) { die('Error: ' . mysqli_error($con)); }
//                 sleep(0.5);
//             }
//         }

//         sleep(0.5);
//     }
//     echo "<br>";
//     mysqli_close($con);
//     print_r($array);

		?>


	</body>
	</html>
