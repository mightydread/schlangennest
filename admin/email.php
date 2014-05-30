<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=1200px">
        <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
        <title>Email liste</title>
        <?php require '../includes/admin.php' ?>
        <link rel="stylesheet" type="text/css" href="../media/global.css">
        <link rel="stylesheet" type="text/css" href="../media/admin.css">
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div id="wrap">
            <div id=email_select>
                <?php create_email_form(); ?>
            </div>
            <div id=email_result>
                <?php
if (isset($_POST['all'])) {
    email_array();
    foreach ($email_array_all as $data) {
        if (!($data)) {}
        else {
            echo "$data, <br>";
        }
    }
}
else {
    if (isset($_POST['electro'])) {
        $cond="electro";
        edit_email_array($cond);
    }
    if (isset($_POST['alternativ'])) {
        $cond="alternativ";
        edit_email_array($cond);
    }
    if (isset($_POST['hiphop'])) {
        $cond="hiphop";
        edit_email_array($cond);
    }
    if (isset($_POST['live'])) {
        $cond="alternativ";
        edit_email_array($cond);
    }
    if (isset($_POST['goodtaste'])) {
        $cond="good_taste";
        edit_email_array($cond);
    }
    if (isset($_POST['quiz'])) {
        $cond="alternativ";
        edit_email_array($cond);
    }
    if (isset($_POST['studenten'])) {
        $cond="studenten";
        edit_email_array($cond);
    }
    if (isset($_POST['kleinkunst'])) {
        $cond="kleinkunst";
        edit_email_array($cond);
    }
    foreach ($email_array as $data) {
        if (!($data)) {}
        else {
            echo "$data, <br>";
        }
    }
}
                ?>
            </div>
        </div>
    </body>
</html>
