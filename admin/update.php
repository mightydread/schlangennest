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