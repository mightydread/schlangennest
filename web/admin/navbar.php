<?php include 'icons_admin.svg' ?>
<div class="nav">
    <ul>
        <li><a href="/"><svg><use xlink:href="#admin_zurueck" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/email.php"){?>class="active"<?php }?>><a href="email.php"><svg><use xlink:href="#admin_email" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/lager_out.php"){?>class="active"<?php }?>><a href="lager_out.php"><svg><use xlink:href="#admin_lager" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/abrechnung.php"){?>class="active"<?php }?>><a href="abrechnung.php"><svg><use xlink:href="#admin_abrechnung" /></svg></a></li>
        <li <?php if($_GET['ratten']==1){?>class="active"<?php }?>><a href="list.php?sort=id&ratten=1" ><svg><use xlink:href="#admin_ratte1" /></svg></a></li>
        <li <?php if($_GET['ratten']==2){?>class="active"<?php }?>><a href="list.php?sort=id&ratten=2" ><svg><use xlink:href="#admin_ratte2" /></svg></a></li>
        <li <?php if($_GET['ratten']==3){?>class="active"<?php }?>><a href="list.php?sort=id&ratten=3" ><svg><use xlink:href="#admin_ratte3" /></svg></a></li>
    </ul>
</div>