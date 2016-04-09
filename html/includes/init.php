<?php
/**
 * Funkcja automatycznie ładuje potrzebną klasę,
 * klasy wyszukiwane są wewnątrz zdefiniowanych w liście folderów.
 * @param String $class_name nazwa klasy do załadowania
 * @return boolean
 */
function __autoload($class_name) {
    $folderList = array("application", "model", "controller", "views");
    $filename = $class_name . '.php';
    
    foreach($folderList as $folder){
        $file = __SITE_PATH . '/'. $folder .'/' . $filename;
        if (file_exists($file)) { 
            break;
        }
    }
    if (!file_exists($file)){
        return false;
    }
    include ($file);
}
