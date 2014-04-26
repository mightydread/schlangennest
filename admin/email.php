<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
    <title>Email liste</title>
    <?php include '../includes/admin.php' ?>
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
            <?php include 'email_list.php' ?>
        </div>
    </div>
</body>

</html>
