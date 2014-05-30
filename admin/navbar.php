<div id=nav>
    <div class="nav_button"><a href="index.html"><img alt=home src="/media/images/home.png" ></a></div>
    <div class="nav_button"><a href="email.php"><img alt=email src="/media/images/email_small.png"></a></div>
    <div class="nav_button"><a href="lager_out.php"><img alt=lager src="/media/images/lager_small.png"></a></div>
    <div id=search>
        <form id=search method=post action=list.php>
            Suche: <input type="search" name="namesearch" value=Name>
        </form>
    </div>
    <div id=ratten>
        <input type=image form=rat_select src="/media/images/list_small.png">
        <form id=rat_select method=post action=list.php>
            <select form=rat_select name=ratten>
                <option value=3>3 Ratten</option>
                <option value=2>2 Ratten</option>
                <option value=1>1 Ratte</option>
            </select>
        </form>
    </div>
</div>
