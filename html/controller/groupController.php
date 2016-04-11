<?php
/**
 * Kontroler operacji na grupach dyskusyjnych
 *
 * @author Mateusz Kuzło
 */
class groupController extends baseController {

    public function index() {
        Template::getInstance()->show("index");
    }

    public function create() {
        if (isset($_SESSION["login"])) {
            Template::getInstance()->show("group/createGroup");
        } else {
            Template::getInstance()->show("index");
        }
    }

    public function addGroup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $type = trim($_POST['type']);
            $db = Database::getInstance();
            $group = new Groups();
            $group->setName($name);
            $group->setDescription($description);
            $group->setType($type);
            $error = "";

            if (strlen($name) > 30) {
                $error = "Nazwa grupy jest zbyt długa<br>Max 30 znaków";
            }
            if (strlen($description) >= 200) {
                $error = "Opis jest zbyt długi<br>Max 200 znaków";
            }
            if (empty($name)) {
                $error = "Nazwa grupy nie może być pusta";
            }
            if ($db->isGroupNameExist($group)) {
                $error = "Grupa o takiej nazwie już istnieje";
            }
            if (!(($type == "private") || ($type == "public"))) {
                $error = "Niepoprawny typ grupy";
            }
            if (empty($error)) {
                if ($db->addGroup($group)) {
                    Template::getInstance()->show("group/createSuccess");
                } else {
                    $error = "Z nieznanych powodów stworzenie grupy nie powiodło się";
                    Template::getInstance()->error = $error;
                    Template::getInstance()->show("group/createGroup");
                }
            } else {
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/createGroup");
            }
        }
    }

}
