<div class="row">
    <div class="col-md-6">
        <div class="row" style="margin-right: 10px;margin-bottom: 10px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Członkowie grupy</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        $role = Database::getInstance()->getUserRoleInGroup($user, $group);
                        if ($role == "member") {
                            ?>   
                            <tr>
                                <td><?= $user->getLogin() ?></td>
                                <td style="text-align: right;"><a href="/<?= APP_ROOT ?>/group/deleteUser/<?= $user->getId() ?>/<?= $group->getId() ?>"><button id="button" class="btn btn-md btn-default">Usuń</button></a></td>
                            </tr> 
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-right: 10px">
            <table class="table">
                <thead>
                    <tr>
                        <th>Oczekujący na przyjęcie</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $waitingUsers = Database::getInstance()->getWaitingOfGroup($group);
                    if ($waitingUsers != FALSE) {
                        foreach ($waitingUsers as $user) {
                            ?>
                            <tr>
                                <td><?= $user->getLogin() ?></td>
                                <td style="text-align: right;">
                                    <a href="/<?= APP_ROOT ?>/group/accept/<?= $user->getId() ?>/<?= $group->getId() ?>"><button id="button" class="btn btn-md btn-default">Akceptuj</button></a>
                                    <a href="/<?= APP_ROOT ?>/group/deleteUser/<?= $user->getId() ?>/<?= $group->getId() ?>"><button id="button" class="btn btn-md btn-default">Odmów</button></a>
                                </td>
                            </tr> 
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </div>
    <div class="col-md-6">
        <div class="row" style="margin-left: 10px; margin-bottom: 10px">

            <form method="POST" action="/<?= APP_ROOT ?>/group/edit">               
                <div class="form-group">
                    <label>Opis grupy: </label>
                    <input type="text" name="description" class="form-control" value="<?=  htmlspecialchars($group->getDescription())?>"/>
                    <input type="hidden" name="id" value="<?= $group->getId() ?>"class="form-control"/> 
                </div>
                <div class="form-group">
                    <label>Typ grupy: </label>  
                    <?php
                        if($group->getType() == 'private'){
                            $private = 'checked';
                            $public = '';
                        }else{
                            $private = '';
                            $public = 'checked';
                        }
                    ?>
                    <div class="radio">
                        <label><input type="radio" name="type" value="private" <?=$private?> required="true"/>Prywatna</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="type" value="public" <?=$public?> required="true"/>Publiczna</label>
                    </div>
                </div> 
                <button type="submit" class="btn btn-default">Edytuj</button> 

            </form>
        </div>
        <div class="row" style="margin-left: 10px; margin-top: 5px; text-align: right">
            <a href="/<?= APP_ROOT ?>/group/delete/<?= $group->getId() ?>">
                <button type="submit" class="btn btn-danger">Usuń grupę</button>
            </a>
        </div>
    </div>
</div>