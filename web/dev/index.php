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
$sql="ALTER TABLE `scandale`.`".$key."` ADD COLUMN `hole` DECIMAL(10,1) NULL AFTER `abgang`;";
    echo $sql;
    echo "<br>";
    }
?>

</body>
</html>
