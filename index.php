<!DOCTYPE html>
<?php
session_start();
//zdefiniowanie zdmiennej z nazwa servera na którem bedzie umieszczona aplikacja
//aplikacja bedzie sprawdzać czy jest uruchomiona na tym serwerze czy lokalnie
//i dobierać odpowiednie parametry zmiennych i ścieżek
define('REMOTE_HOST', 'grupa.esy.es');
if (REMOTE_HOST == $_SERVER['SERVER_NAME']) {
    $local = FALSE;
} else {
    $local = TRUE;
}
define('IS_LOCAL', $local);
if (IS_LOCAL) {
    //zmienne dla aplikacji na localhost
    define('__SITE_PATH', realpath(dirname(__FILE__) . "/html"));
    define('APP_ROOT', 'grupa');
    define('IMAGE_ROOT', getcwd() . '/images/');
} else {
    //zmiienne dla aplikacji na serwerze
    define('__SITE_PATH', "./html");
    define('APP_ROOT', '.');
    define('IMAGE_ROOT', getcwd() . '/images/');
}
//dołączenie pliku z automatycznym ładowaniem klas
include __SITE_PATH . '/includes/init.php';
$router = new Router();
$router->setPath(__SITE_PATH . '/controller')
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Grupa dyskusyjna</title>
        <!--Dołączenie arkusza stylów css biblioteki bootstrap -->
        <link rel="stylesheet" href="/<?= APP_ROOT ?>/html/content/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="/<?= APP_ROOT ?>/html/content/css/myStyles.css" type="text/css" />   
        <!--Dołączenie skrytpu javascript biblioteki jquery -->
        <script src="/<?= APP_ROOT ?>/html/content/scripts/jquery-1.11.2.min.js"></script> 
        <script type="text/javascript" src="/<?= APP_ROOT ?>/html/content/scripts/bootstrap-filestyle.min.js"></script>
        <script type="text/javascript" src="/<?= APP_ROOT ?>/html/content/scripts/myScript.js"></script>
    </head>
    <body>
<?php include 'html/includes/menu.php'; ?> 
        <div class="container">
            <div class="row">

<?php $router->loader(); ?>

            </div>
        </div>
        <!--Dołączenie skrytpu javascript biblioteki bootstrap -->
        <script src="/<?= APP_ROOT ?>/html/content/scripts/bootstrap.min.js"></script> 
    </body>
</html>
