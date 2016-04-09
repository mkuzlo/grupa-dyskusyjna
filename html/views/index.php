<?php

if (!isset($_SESSION['login'])) {
    ?>
    <center>
        <h1>Witamy na grupie dyskusyjnej.</h1>
        <h3>Zaloguj się lub załóż nowe konto.</h3>
    </center>
<?php } else { ?>
    <center>
        <h2>Tu w przyszłości pojawi się zawartość grupy dyskusyjnej.</h2>
    </center>

<?php } ?>
