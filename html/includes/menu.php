<?php
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
}
if (empty($login)) {
    ?>
    <!--Menu dla gościa-->
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/<?= APP_ROOT ?>">Grupa dyskusyjna</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <div class="navbar-form navbar-right">
                    <a class="btn btn-warning" href="/<?= APP_ROOT ?>/account/register">Rejestracja</a> 
                </div>
                <form class="navbar-form navbar-right" method="POST" action="/<?= APP_ROOT ?>/account/login">
                    <div class="form-group">
                        <input type="text" name="login" placeholder="Login" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Hasło" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Zaloguj</button>
                </form>

            </div>
        </div>
    </nav>

    <?php
} else {
    ?>

    <!--menu dla użytkownika-->
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/<?= APP_ROOT ?>">Grupa dyskusyjna</a>
            </div>      
            <div class="nav navbar-nav navbar-right">
                <span style="color: whitesmoke;font-size: 18px">Zalogowany: <?= $_SESSION['login'] ?></span>             
                <a class="btn btn-danger" style="margin: 10px; margin-bottom: 5px;" href="/<?= APP_ROOT ?>/account/logout">Wyloguj</a> 
            </div>
        </div>
    </nav>
<?php }
?> 