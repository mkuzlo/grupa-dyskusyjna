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
        <form method="POST" action="/<?= APP_ROOT ?>/group/addGroup">   
            <div class="form-group">
                <label>Nazwa grupy: </label>
                <input type="text" name="name" class="form-control" required="true"/> 
            </div>
            <div class="form-group">
                <label>Opis grupy: </label>
                <input type="text" name="description" class="form-control"/> 
            </div>
            <div class="form-group">
                <label>Typ grupy: </label>               
                <div class="radio">
                    <label><input type="radio" name="type" value="private"  required="true"/>Prywatna</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="type" value="public" required="true"/>Publiczna</label>
                </div>
            </div> 
            <button type="submit" class="btn btn-default">Stwórz grupę</button> 

        </form>
    </div>
</div>