<?php

if (!isset($_SESSION['login'])) {
    ?>
    <center>
        <h1>Witamy na grupie dyskusyjnej.</h1>
        <h3>Zaloguj się lub załóż nowe konto.</h3>
    </center>
<?php } else { ?>
    <center>
        <h2>Witaj <?= $_SESSION['login'] ?></h2><br>
        <h4>Możesz stworzyć nową grupę dyskusyjną, dołączyć do istniejącej lub zacząć rozmowę w grupach do których już należysz.</h4>
        <h4></h4>
    </center>

<?php } ?>
