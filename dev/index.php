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
$con_lager = mysqli_connect(localhost,root,pcfreak,Lager_test);
foreach (waren(kasten) as $typ) {
    $sql = "ALTER TABLE $typ CHANGE verbrauch verbrauch SMALLINT(4) UNSIGNED NOT NULL;";
    if (!mysqli_query($con_lager,$sql)) { die('Error: ' . mysqli_error($con_lager)); }
}
    print_r($_SESSION);
     // session_destroy();

?>

    </body>
    </html>
