<?php include 'icons_admin.svg' ?>
<div class="nav">
    <ul>
        <li><a href="/"><svg><use xlink:href="#admin_zurueck" /></svg></a></li>
        <li <?php if($_SERVER["SCRIPT_NAME"]=="/admin/lager_out.php"){?>class="active"<?php }?>><a href="lager_out.php?year=<?php echo getdate()['year'];?>&month=<?php echo getdate()['mon'];?>"><svg><use xlink:href="#admin_lager" /></svg></a></li>
    </ul>
</div>