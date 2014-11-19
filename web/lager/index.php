<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lager</title>
    <meta name="viewport" content="width=700">
    <link rel="stylesheet" type="text/css" href="/media/css/lager.css">
    <?php require 'lager.php' ?>
</head>
<body>
<?php populate_session(get_date()); ?>
   <div id="wrap">
   <?php include 'navbar.php' ?>
    <div>
     <h1>Hinweis</h1> 
     <p>Erst Lieferung oder Abgang eintragen dann Inventur machen.</p>
     <p>Bei Problemen Mighty anrufen: 015252680305</p> 
    </div>
</div>
</body>
</html>
