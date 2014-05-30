<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=1200px">
        <meta http-equiv="content-type" content="text/html; charset=utf-8mb4" />
        <title>Mitglieder</title>
        <?php require '../includes/admin.php' ?>
        <?php
    if    (isset($_POST['save'])) {
    if  (isset($_POST['name'])) {update_db($_POST['id'],$_POST['name'],name);}
    if  (isset($_POST['email'])) {update_db($_POST['id'],$_POST['email'],email);}
    if  (isset($_POST['telefon'])) {update_db($_POST['id'],$_POST['telefon'],telefon);}
    if  (isset($_POST['electro'])) {update_db($_POST['id'],$_POST['electro'],electro);}
    if  (isset($_POST['alternativ'])) {update_db($_POST['id'],$_POST['alternativ'],alternativ);}
    if  (isset($_POST['hiphop'])) {update_db($_POST['id'],$_POST['hiphop'],hiphop);}
    if  (isset($_POST['live'])) {update_db($_POST['id'],$_POST['live'],live);}
    if  (isset($_POST['good_taste'])) {update_db($_POST['id'],$_POST['good_taste'],good_taste);}
    if  (isset($_POST['quiz'])) {update_db($_POST['id'],$_POST['quiz'],quiz);}
    if  (isset($_POST['studenten'])) {update_db($_POST['id'],$_POST['studenten'],studenten);}
    if  (isset($_POST['kleinkunst'])) {update_db($_POST['id'],$_POST['kleinkunst'],kleinkunst);}
}
        ?>

        <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div id="wrap">
            <?php if(isset($_POST['ratten'])){create_edit_table($_POST['ratten']);}
elseif (isset($_POST['namesearch'])){search_name($_POST['namesearch']);}
else {create_edit_table(3);}
if    (isset($_POST['new'])) {
    check_for_row($_POST['id']);
    if  ($exist == true)    {   echo "<div class=message>Nummer existiert schon!</div>";   }
    elseif ($exist == false)    {
        add_to_db($_POST['id'],$_POST['name'],$_POST['ratten']);
        echo "<div class=message>Mitglied hinzugefügt!</div>";
    }
} ?>
        </div>
    </body>
</html>
