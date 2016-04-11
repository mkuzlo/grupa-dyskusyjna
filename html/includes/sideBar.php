<?php if (isset($_SESSION["login"])) { ?>
    <div class="mySideBar">
        <ul>
            <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/create">Stwórz grupę</a></li>
            <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/find">Dołącz do grupy</a></li>
        </ul>
        <div class="line-separator"></div>
        <ul class="groups">

            <?php
            $array = Database::getInstance()->getUserGroups();
            if ($array != FALSE) {
                foreach ($array as $group) {
                    $id = $group->getId();
                    $name = $group->getName();
                    ?>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/<?=$id ?>"><?=$name ?></a></li>

                    <?php
                }
            }
            ?>
        </ul>
    </div>
<?php } ?>