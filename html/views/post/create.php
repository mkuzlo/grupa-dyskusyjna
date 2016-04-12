<form method="POST" action="/<?= APP_ROOT ?>/post/add/<?= $group->getId() ?>" enctype="multipart/form-data"> 
    <h3>Dodaj nowy post w grupie <?= $group->getName() ?> </h3>
    Limit znaków: <span id="counter">0/2000</span><br>
    <div class="form-group">
        <label>Treść wiadomości:</label>
        <textarea name="message" id="message" class="form-control" rows="5" onkeyup="changeCounter()" onchange="changeCounter()"></textarea>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label>Plik graficzny (max 1MB):</label>
                <input type="file" name="file"  class="filestyle" data-buttonText="Dodaj" accept="image/*">
            </div>
        </div>
        <div class="col-md-2  pull-right sendPost">
            <button type="submit" id="button" class="btn btn-lg btn-default ">Wyślij</button> 
        </div>
    </div>
</form>