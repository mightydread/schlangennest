<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Email liste</title>
    <?php include 'admin_functions.php' ?>
    <link rel="stylesheet" type="text/css" href="../media/global.css">
    <link rel="stylesheet" type="text/css" href="../media/admin.css">
</head>

<body>
    <?php include 'navbar.php' ?>
    <div id="content_email">
        <div id=email_select>
            <?php create_email_form(); ?>
        </div>
        <div id=email_result>
            <?php include 'email_list.php' ?>
        </div>
    </div>
</body>

</html>
