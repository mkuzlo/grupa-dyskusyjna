<?php

/**
 * Klasa odpowiedzialna za wyświetlanie widoków i zmiennych widoku
 *
 * @author Mateusz Kuzło
 */
class Template {

    private $vars = array();
    private static $instance = false;

    private function __construct() {
        $vars = array();
    }

    /**
     * Zwraca instancję tej klasy
     * @return Template 
     */
    public static function getInstance() {
        if (self::$instance == false) {
            self::$instance = new Template();
        }
        return self::$instance;
    }

    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

    public function show($name) {
        $path = __SITE_PATH . '/views/' . $name . '.php';
        if (file_exists($path) == false) {
            throw new Exception('Template not found in ' . $path);
        }
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }


        include 'html/includes/sideBar.php';
        echo "<div class='col-md-9'>";
        include $path;
        echo "</div>";
    }

}
