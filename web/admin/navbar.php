<div class="nav">
    <ul>
        <li><a href="/"><?php include '../media/images/icons_zurueck.svg' ?></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/email.php"){?>class="active"<?php }?>><a href="email.php"><?php include '../media/images/icons_email.svg' ?></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/lager_out.php"){?>class="active"<?php }?>><a href="lager_out.php"><?php include '../media/images/icons_lager_schwarz.svg' ?></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/abrechnung.php"){?>class="active"<?php }?>><a href="abrechnung.php"><?php include '../media/images/icons_abrechnung.svg' ?></a></li>
        <li <?php if($_GET['ratten']==1){?>class="active"<?php }?>><a href="list.php?sort=id&ratten=1" ><?php include '../media/images/icons_ratte1.svg' ?></a></li>
        <li <?php if($_GET['ratten']==2){?>class="active"<?php }?>><a href="list.php?sort=id&ratten=2" ><?php include '../media/images/icons_ratte2.svg' ?></a></li>
        <li <?php if($_GET['ratten']==3){?>class="active"<?php }?>><a href="list.php?sort=id&ratten=3" ><?php include '../media/images/icons_ratte3.svg' ?></a></li>
    </ul>
</div>