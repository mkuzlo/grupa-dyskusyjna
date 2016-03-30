<!DOCTYPE html>
<?php
    //rozpoczęcie sesji
    session_start();
    //zdefiniowanie stałych ze scieżką
    define('__SITE_PATH', realpath(dirname(__FILE__) . "/html"));
    define('APP_ROOT', 'grupa');
    //dołączenie pliku z automatycznym ładowaniem klas
    include __SITE_PATH . '/includes/init.php'; 

    //Dodanie nowego użytkownika do bazy danych
    $db = Database::getInstance();
    $user = new Users();
    $user->setLogin("test1");
    $user->setPassword("haslo1");
    $db->addUser($user);
?>
<html>
    <head>
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Grupa dyskusyjna</title>
        <!--Dołączenie arkusza stylów css biblioteki bootstrap -->
        <link rel="stylesheet" href="/<?= APP_ROOT ?>/html/content/css/bootstrap.min.css" type="text/css" />     
        <!--Dołączenie skrytpu javascript biblioteki jquery -->
        <script src="/<?= APP_ROOT ?>/html/content/scripts/jquery-1.11.2.min.js"></script> 
    </head>
    <body>
        Treść
        
        <!--Dołączenie skrytpu javascript biblioteki bootstrap -->
        <script src="/<?= APP_ROOT ?>/html/content/scripts/bootstrap.min.js"></script> 
    </body>
</html>
