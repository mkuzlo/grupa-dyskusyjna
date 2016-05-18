<?php
/**
 * Kontroler działań użytkownika
 * Odpowiada za logowanie się, wylogowywanie i zakładanie 
 * nowego konta.
 *
 * @author Mateusz Kuzło
 */
class accountController extends baseController {

    public function index() {
        Template::getInstance()->show("index");
    }

    public function logout() {
        session_destroy();
        $location = APP_ROOT;
        header("Location: /$location");
    }

    public function login() {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $login = trim($_POST['login']);
            $password = trim($_POST['password']);
            $db = Database::getInstance();
            $user = new Users();
            $user->setLogin($login);
            $user->setPassword($password);

            if ($db->isUserAndPasswordExist($user)) {
                $_SESSION['login'] = $user->getLogin();
                $location = APP_ROOT;
                header("Location: /$location");
            }
        }
        Template::getInstance()->show("account/loginFailed");
    }

    public function register() {
        Template::getInstance()->show("account/register");
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = trim($_POST['login']);
            $password = trim($_POST['password']);
            $password2 = trim($_POST['password2']);
            $db = Database::getInstance();
            $user = new Users();
            $user->setLogin($login);
            $user->setPassword($password);
            $error = "";
            if(strlen($user->getPassword())>=40){
                $error = "Hasło jest zbyt długie";
            }
            if (empty($login) || empty($password) || empty($password2)) {
                $error = "Nie wypełniono wszystkich wymaganych pól";
            }
            if (!($password == $password2)) {
                $error = "Hasła nie są identyczne";
            }
            if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{3,30}$/', $login) ){
                $error = "Niepopoprawny login<br>-Dozwolona długość 4-29 znaków<br>"
                        . "-Tylko litery i cyfry<br>-Musi zaczynać się od litery<br>";
            }
            if ($db->isUserExist($user)) {
                $error = "Użytkownik o takim loginie już istnieje";
            }
            if (empty($error)) {
                if ($db->addUser($user)) {
                    Template::getInstance()->show("account/registerSucces");
                } else {
                    $error = "Z nieznanych powodów założenie konta nie powiodło się";
                }
            } else {
                Template::getInstance()->error = $error;
                Template::getInstance()->show("account/register");
            }
        }
    }

}
