<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8mb4">
    <title>Lager Ausgabe</title>
    <?php include '../includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="../media/global.css">
    <link rel="stylesheet" type="text/css" href="../media/admin.css">
</head>

<body>
    <div id="wrap">
    Under Development

    <?php foreach (waren(kasten) as $typ) { echo full_name($typ); } ?>
    </div>
</body>
</html>
