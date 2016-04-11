<?php

/**
 * Klasa typu singletion, zawiera instancję bazy danych, oraz
 * metody opertujące na tej bazie danych.
 *
 * @author Mateusz Kuzło
 */
class Database {

    private static $instance = false;
    private $username = "root";
    private $password = "";
    private $conf = "mysql:host=localhost;dbname=grupa;encoding=utf8;";
    private $PDO;

    private function __construct() {
        $this->PDO = new PDO($this->conf, $this->username, $this->password);
    }

    /**
     * Zwraca instancję tej klasy
     * @return Database 
     */
    public static function getInstance() {
        if (self::$instance == false) {
            self::$instance = new Database;
        }
        return self::$instance;
    }

    /**
     * Dodaje nowego użytkownika do bazy danych     * 
     * @param Users $user
     * @return boolean zwraca TRUE jeżeli dodanie powiodło się,
     *  FALSE jeżeli nie powiodło się.
     */
    public function addUser($user) {
        $query = $this->PDO->prepare("INSERT INTO USERS(login,password) VALUES(:login,:password)");
        $query->bindValue(":login", $user->getLogin());
        $query->bindValue(":password", $user->getPassword());
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Sprawdza czy uzytkownik o danym loginie i haśle istnieje w bazie danych
     * @param type $user
     * @return boolean
     */
    public function isUserAndPasswordExist($user) {
        $query = $this->PDO->prepare("SELECT * FROM USERS WHERE login=:login AND password=:password");
        $query->bindValue(":login", $user->getLogin());
        $query->bindValue(":password", $user->getPassword());
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Sprawdza czy uzytkownik o danym loginie istnieje w bazie danych
     * @param type $user
     * @return boolean
     */
    public function isUserExist($user) {
        $query = $this->PDO->prepare("SELECT * FROM USERS WHERE login=:login");
        $query->bindValue(":login", $user->getLogin());
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Sprawdza czy grupa o takiej nazwie już istnieje
     * @param type $group
     * @return boolean
     */
    public function isGroupNameExist($group) {
        $query = $this->PDO->prepare("SELECT * FROM GROUPS WHERE name=:name");
        $query->bindValue(":name", $group->getName());
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Dodaje nową grupę do bazy danych
     * @param type $group
     * @return boolean
     */
    public function addGroup($group) {
        $query = $this->PDO->prepare("INSERT INTO GROUPS(name,description,type) VALUES(:name,:description,:type)");
        $query->bindValue(":name", $group->getName());
        $query->bindValue(":description", $group->getDescription());
        $query->bindValue(":type", $group->getType());
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            if ($this->addModerator($group)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Wraz z tworzeniem nowej grupy użytkownij zostaje przypisany jak jej moderator
     * @param type $group
     * @return boolean
     */
    private function addModerator($group) {
        $user = $this->getUserBySessionLogin();
        $group2 = $this->getGroupByName($group->getName());
        $query = $this->PDO->prepare("INSERT INTO USER_GROUPS(`user`,`group`,`role`) VALUES(:user,:group,:role)");
        $query->bindValue(":user", $user->getId());
        $query->bindValue(":group", $group2->getId());
        $query->bindValue(":role", "moderator");
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Zwraca grupę o podanej nazwie
     * @param type $name
     * @return \Groups|boolean
     */
    public function getGroupByName($name) {
        $query = $this->PDO->prepare("SELECT * FROM GROUPS WHERE name=:name");
        $query->bindValue(":name", $name);
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $group = new Groups();
            $group->setId($result["id"]);
            $group->setName($result["name"]);
            $group->setDescription($result["description"]);
            $group->setType($result["type"]);
            return $group;
        }
        return FALSE;
    }

    /**
     * Zwraca użytkownika akltualnie zalogowanego
     * @return boolean|\Users
     */
    public function getUserBySessionLogin() {
        $query = $this->PDO->prepare("SELECT * FROM USERS WHERE login=:login");
        $query->bindValue(":login", $_SESSION["login"]);
        $query->execute();
        $affected_rows = $query->rowCount();
        if ($affected_rows == 1) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $user = new Users();
            $user->setId($result["id"]);
            $user->setPassword($result["password"]);
            $user->setLogin($result["login"]);
            return $user;
        }
        return FALSE;
    }
}
