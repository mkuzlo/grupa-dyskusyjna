<form method="POST" action="/<?= APP_ROOT ?>/post/edit/<?= $post->getId() ?>"> 
    <h3>Edycja postu </h3>
    Limit znaków: <span id="counter">0/2000</span><br>
    <div class="form-group">
        <label>Treść wiadomości:</label>
        <textarea name="message" id="message" class="form-control" rows="5" 
                  onkeyup="changeCounter()" onchange="changeCounter()"><?=htmlspecialchars($post->getMessage()) ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-2  pull-right sendPost">
            <button type="submit" id="button" class="btn btn-lg btn-default ">Edytuj</button> 
        </div>
    </div>
</form>