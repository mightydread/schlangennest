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
    Sucess!!!<br>

<?php 
$time=strtotime("4.6.2014");
print_r($time);
$date=date("Y-m-d",$time);
print_r($date); ?>


    </body>
    </html>
