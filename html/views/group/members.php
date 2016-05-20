<div class="row">
    <div class="col-md-6">
        <div class="alert alert-info" role="alert" style="margin-top: 20px">
            Ilość członków grupy <?= htmlspecialchars($group->getName()) ?>: <?= count($users) ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Rola</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($users as $user) {
                    ?>   
                    <tr>
                        <td><?= $user->getLogin() ?></td>
                        <td><?php
                            $role = Database::getInstance()->getUserRoleInGroup($user, $group);
                            if ($role == "member") {
                                echo "<font color='green'>Członek</span>";
                            } else {
                                echo "<font color='red'>Moderator</span>";
                            }
                            ?></td>
                    </tr> 
                <?php } ?>
            </tbody>
        </table>
        <?php
        $role = Database::getInstance()->getUserRoleInGroup($user, $group);
        if ($role == 'member') {
            ?>
            <div>
                <a href="/<?= APP_ROOT ?>/group/leave/<?= $group->getId() ?>" ><button id="button" class="btn btn-lg btn-default ">Opuść grupę</button> </a>
            </div>
            <?php
        }
        ?>

    </div>
</div>