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