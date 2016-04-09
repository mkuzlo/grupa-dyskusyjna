
<?php
if (!empty($error)) {
    ?>
    <div class="row">
        <div class="col-md-5">
            <div class="alert alert-danger" role="alert">
                <h4><?= $error ?></h4>
            </div>
        </div>    
    </div>
    <?php
}
?>


<div class="row">
    <div class="col-md-5">
        <form method="POST" action="/<?= APP_ROOT ?>/account/addUser">   
            <div class="form-group">
                <label>Login: </label>
                <input type="text" name="login" class="form-control" required="true"/> 
            </div>
            <div class="form-group">
                <label>Hasło: </label>
                <input type="password" name="password" class="form-control" required="true"/> 
            </div>
            <div class="form-group">
                <label>Powtórz hasło: </label>
                <input type="password" name="password2" class="form-control" required="true"/> 
            </div> 
            <button type="submit" class="btn btn-default">Zarejestruj</button> 

        </form>
    </div>
</div>
