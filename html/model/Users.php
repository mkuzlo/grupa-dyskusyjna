<?php
/**
 * Description of Users
 *
 * @author Mateusz Kuzło
 */
class Users {
    private $id;
    private $login;
    private $password;
    
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
