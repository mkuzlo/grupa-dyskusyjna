<?php if (isset($_SESSION["login"])) { ?>
    <div class="col-md-3"> 
        <div class="mySideBar">
            <ul>

                <?php if (!isset($group)) { ?>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/create">Stwórz grupę</a></li>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/find">Dołącz do grupy</a></li>
                <?php } else { ?>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/<?= $group->getId() ?>">Wyświetl grupę</a></li>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/post/create/<?= $group->getId() ?>">Dodaj post</a></li>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/members/<?= $group->getId() ?>">Wyświetl członków</a></li>
                    <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/edit/<?= $group->getId() ?>">Zarządzaj</a></li>
                <?php } ?>
            </ul>
            <div class="line-separator"></div>
            <ul class="groups">

                <?php
                $myGroups = Database::getInstance()->getUserGroups();
                if ($myGroups != FALSE) {
                    foreach ($myGroups as $myGroup) {
                        $id = $myGroup->getId();
                        $name = $myGroup->getName();
                        ?>
                        <li><a class="sideLink" href="/<?= APP_ROOT ?>/group/show/<?= $id ?>"><?= $name ?></a></li>
                            <?php
                        }
                    }
                    ?>
            </ul>
        </div>
    </div>
<?php } ?>