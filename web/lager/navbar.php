<?php include 'icons_lager.svg' ?>
<div class="nav">
    <ul>
        <li><a href="/"><svg><use xlink:href="#lager_zurueck" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/lager/lieferung.php"){?>class="active"<?php }?>><a href="lieferung.php"><svg><use xlink:href="#lager_lieferung" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/lager/inventur.php"){?>class="active"<?php }?>><a href="inventur.php"><svg><use xlink:href="#lager_inventur" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/lager/abgang.php"){?>class="active"<?php }?>><a href="abgang.php"><svg><use xlink:href="#lager_abgang" /></svg></a></li>
    </ul>
</div>