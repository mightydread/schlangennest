<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=850px">
    <title>Email liste</title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/includes/admin.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
</head>
<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <div class=boxes>
            <form method=post action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="email">
                <ul>
                    <li><input class=checkbox id="all" name=all value=1 type=checkbox><div class=label ><label for="all">Alle</label></div></li>
                    <li><input class=checkbox id="electro" name=electro value=1 type=checkbox><div class=label ><label for="electro" >Elektro</label></div></li>
                    <li><input class=checkbox id="alternativ" name=alternativ value=1 type=checkbox><div class=label ><label for="alternativ" >Alternativ</label></div></li>
                    <li><input class=checkbox id="hiphop" name=hiphop value=1 type=checkbox><div class=label ><label for="hiphop" >Hip Hop</label></div></li>
                    <li><input class=checkbox id="live" name=live value=1 type=checkbox><div class=label ><label for="live" >Live</label></div></li>
                    <li><input class=checkbox id="good_taste" name=good_taste value=1 type=checkbox><div class=label ><label for="good_taste" >Good taste</label></div></li>
                    <li><input class=checkbox id="quiz" name=quiz value=1 type=checkbox><div class=label ><label for="quiz" >Quiz</label></div></li>
                    <li><input class=checkbox id="studenten" name=studenten value=1 type=checkbox><div class=label ><label for="studenten" >Studenten</label></div></li>
                    <li><input class=checkbox id="kleinkunst" name=kleinkunst value=1 type=checkbox><div class=label ><label for="kleinkunst" >Kleinkunst</label></div></li>
                    <li><input class=checkbox id="telefon" name=telefon value=1 type=checkbox disabled><div class=label ><label for="telefon">SMS</label></div></li>
                    <li><input class=save id="save" name=save value=save type=image src="/media/images/save.png"><div class=label ><label for="save" >OK</label></div></li>
                </ul>
            </form>
        </div>
        <?php if (isset($_POST['save'])) { ?>
        <?php unset($_POST['save']);unset($_POST['save_x']);unset($_POST['save_y']);foreach($_POST as $key => $value) {$temp=email_array($key);$temp = array_diff($temp,$email_array);$email_array = array_merge_recursive($email_array,$temp);}?>
        <div class="email_link">
            <a href="mailto:<?php foreach ($email_array as $data) {if (!($data)) {} else {echo "$data".", ";}} ?>" >Email Verschicken</a>
        </div>
        <div class="email_link">
            <label for="paneltoggle">Emails Anzeigen<label>
        </div>
        <div class="email_panel">
        <input type="checkbox" id="paneltoggle" />
        <div id="email_result">
            <?php foreach ($email_array as $data) {if (!($data)) {} else {echo "<nobr class=nobr>$data".",</nobr> ";}} ?>
        </div>
    </div> <?php }?>
    </div>

</body>
</html>
