<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=850px">
    <title>Veranstaltungen</title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
    <?php if (isset($_POST['save'])) { new_va(date('Y-m-d', strtotime($_POST['datum'])),$_POST['name']);} ?>
</head>

<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <div id="va_panel">
           <ul class="va_row">
            <li class="va_datum">Datum</li>
            <li class="va_name">Name</li>
            <li class="va_umsatz">Umsatz</li>

        </ul> 
        <?php foreach (all_va() as $key => $value) { ?>
        <ul class="va_row">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                            <input type="hidden" name=datum value="<?php echo $value['datum']; ?>">
            <li class="va_datum"><?php echo date('d.m.y', strtotime($value['datum'])); ?></li>
            <li class="va_name"><?php echo $value['name']; ?></li>
            <li class="va_umsatz"><?php echo umsatz_berechnen($value['datum'])." €";?></li>
                            <input type=submit name="save_datum" value="Abrechnen">
            
                        </form>
        </ul> 
        <?php } ?>
        <form class="va_row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="new">
            <input class="va_datum" type="date" name="datum" >
            <input class="va_name" type="text" name="name" >
            <input type="submit" name="save" form="new">
        </form>
    </div>
</div>
</body>
</html>
