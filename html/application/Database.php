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

}
