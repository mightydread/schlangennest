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
populate_session('2014-11-13');
print_r($_SESSION);
?>

</body>
</html>
