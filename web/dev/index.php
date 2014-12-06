<?php session_destroy(); ?>
<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" >
	<title>Development Area</title>
	<?php require 'admin.php' ?>

	<?php require 'lager.php' ?>

	<link rel="stylesheet" type="text/css" href="../media/css/admin.css">
</head>
<body>

<?php 
foreach (waren() as $key) {
$sql="DELETE FROM `scandale`.`".$key."` WHERE datum='2014-12-01';";
    echo $sql;
    echo "<br>";
    }
?>

</body>
</html>
