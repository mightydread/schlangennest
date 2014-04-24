<?php
if    (isset($_POST['new'])) {
    select_row($_POST['id']);
    if  ($exist)    {   echo "<div class=message>Nummer existiert schon!</div>";   }
    elseif (!$exist)    {
        add_to_db($_POST['id'],$_POST['name'],$_POST['ratten']);
        echo "<div class=message>Mitglied hinzugefügt!</div>";
    }
}
?>