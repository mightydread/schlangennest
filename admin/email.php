<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=850px">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Email liste</title>
    <?php require '../includes/admin.php' ?>
                

    <link rel="stylesheet" type="text/css" href="/media/css/admin.css">
</head>
<body>
    <div id="wrap">
        <?php include 'navbar.php' ?>
        <div class=boxes>
            <form method=post action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="email">
                <ul>
                    <li><input class=checkbox name=all value=1 type=checkbox><div class=label >Alle</div></li>
                    <li><input class=checkbox name=electro value=1 type=checkbox><div class=label >Elektro</div></li>
                    <li><input class=checkbox name=alternativ value=1 type=checkbox><div class=label >Alternativ</div></li>
                    <li><input class=checkbox name=hiphop value=1 type=checkbox><div class=label >Hip Hop</div></li>
                    <li><input class=checkbox name=live value=1 type=checkbox><div class=label >Live</div></li>
                    <li><input class=checkbox name=good_taste value=1 type=checkbox><div class=label >Good Taste</div></li>
                    <li><input class=checkbox name=quiz value=1 type=checkbox><div class=label >Quiz</div></li>
                    <li><input class=checkbox name=studenten value=1 type=checkbox><div class=label >Studenten</div></li>
                    <li><input class=checkbox name=kleinkunst value=1 type=checkbox><div class=label >Kleinkunst</div></li>
                    <li><input class=checkbox name=telefon value=1 type=checkbox disabled><div class=label >SMS</div></li>
                    <li><input class=save name=save value=save type=image src="/media/images/save.png"><div class=label >OK</div></li>
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
