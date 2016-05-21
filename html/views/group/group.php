<script>
    setInterval(function () {
        $.ajax({
            type: 'POST',
            url: '/<?= APP_ROOT ?>/html/ajax/newPost',
            data: {
                group: "<?= $group->getId() ?>",
                ajax: "1"

            },
            cache: false,
            success: function (result) {
                if(result >= 1) location.reload();
            }
        });
    }, 6000);
</script>
   
    <?php
    if (empty($posts)) {
        ?>
        <div id="noPosts" class="alert alert-info" role="alert">
            <h2>Brak postów do wyświetlania</h2>
        </div>
    <?php
} else {
    $user = Database::getInstance()->getUserBySessionLogin();
    $role = Database::getInstance()->getUserRoleInGroup($user, Database::getInstance()->getGroupById($group->getId()));
    foreach ($posts as $post) {
        ?>
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #353535; color: #FFF; height: 55px;  ">

                    <div style="float: left">
                        <h3 class="panel-title" style="font-weight: bold;"><?= Database::getInstance()->getUserById($post->getUser())->getLogin() ?></h3>
                        <h3 class="panel-title" style="padding-top: 3px;"> <?= $post->getDate() ?></h3>
                    </div>
                    <div style="float: right">
        <?php
        if ($post->getUser() == $user->getId()) {
            ?>
                            <a href="/<?= APP_ROOT ?>/post/edit/<?= $post->getId() ?>"><img src="../../resources/edit.png"  title="Edytuj" class="my_icon"></a>
                            <?php
                        }
                        ?>
                        <?php
                        if ($post->getUser() == $user->getId() || $role == 'moderator') {
                            ?>
                            <a href="/<?= APP_ROOT ?>/post/delete/<?= $post->getId() ?>"><img src="../../resources/delete.png"  title="Usuń" class="my_icon"></a>
                            <?php
                        }
                        ?>
                    </div>

                </div>
                <div class="panel-body">
        <?= htmlspecialchars($post->getMessage()) ?><br>
        <?php if (!empty($post->getImage())) { ?>
                        <img src="<?= "../../images/" . $post->getImage() ?>" class="img-thumbnail">     
                    <?php } ?>
                </div>

            </div>

        <?php
    }
}
?>
