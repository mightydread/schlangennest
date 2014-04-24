<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Administrator</title>
    <?php include 'admin_functions.php' ?>
    <?php include 'update.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/admin.css">
</head>

<body>
    <?php include 'navbar.php' ?>
    <div id="content_list">
        <?php if(isset($_POST[ 'ratten'])){create_edit_table($_POST[ 'ratten']);}?>
        <?php include 'add.php' ?>
    </div>

</body>

</html>
