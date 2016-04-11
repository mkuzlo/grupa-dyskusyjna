<div class="row">
    <div class="col-md-8">
        <form method="POST" action="/<?= APP_ROOT ?>/group/find">   
            <div class="form-group">
                <label>Wyszukaj grupę: </label>
                <input type="text" name="pattern" class="form-control"/> 
            </div>
            <div class="form-group">            
                <div class="radio">
                    <label><input type="radio" name="type" value="name"  required="true" checked/>Nazwa</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="type" value="description" required="true"/>Opis</label>
                </div>
            </div> 
            <button type="submit" class="btn btn-default">Wyszukaj</button> 
        </form>
    </div>
</div>
<?php
if (isset($number) ) {
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert" style="margin-top: 20px">
                Znaleziono <?= $number ?> grup.
            </div>


            <table class="table">
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Typ</th>
                        <th>Opis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($array as $group) {
                        ?>   
                        <tr>
                            <td><?= $group->getName() ?></td>
                            <td><?php
                                if ($group->getType() == "public") {
                                    echo "<font color='green'>publiczna</span>";
                                } else {
                                    echo "<font color='red'>prywatna</span>";
                                }
                                ?></td>
                            <td><?= $group->getDescription() ?></td>
                            <td>
                                <?php if (!Database::getInstance()->isSessionUserMemberOfGroup($group)) { ?>
                                    <a class="btn btn-success" href="/<?= APP_ROOT ?>/group/join/<?= $group->getId() ?>">Dołącz</a>
                                <?php } ?>
                            </td>
                        </tr> 
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
}
?>