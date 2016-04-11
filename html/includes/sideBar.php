<?php if(!isset($_SESSION["group"]) && isset($_SESSION["login"])) { ?>
<div class="mySideBar">
    <ul>
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/create">Stwórz grupę</a></li>
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/look">Dołącz do grupy</a></li>
    </ul>
    <div class="line-separator"></div>
    <ul class="groups">
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/1">Grupa1</a></li>
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/2">Grupa2</a></li>
    </ul>
    
</div>
<?php }?>

<?php if(isset($_SESSION["group"]) && isset($_SESSION["login"])) { ?>
<div class="mySideBar">
    <ul>
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/create">Stwórz grupę</a></li>
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/look">Dołącz do grupy</a></li>
    </ul>
    <div class="line-separator"></div>
    <ul class="groups">
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/1">Grupa1</a></li>
        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/2">Grupa2</a></li>
    </ul>
    
</div>
<?php }?>