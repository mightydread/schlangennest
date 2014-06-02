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
    Sucess!!!<br>
    <?php
$test=array("test1"=>1,"test2"=>2);
print_r($test);
echo "<br><br>";

$test_1[]=$test;
$test_1[]=$test;
print_r($test_1);
echo $test_1[0][test1];
?>

    </body>
    </html>
