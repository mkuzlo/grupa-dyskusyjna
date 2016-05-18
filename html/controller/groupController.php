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

    public function find() {
        if (isset($_SESSION["login"])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $type = trim($_POST['type']);
                $pattern = trim($_POST['pattern']);
                $array = Database::getInstance()->getGroupsByPattern($pattern, $type);
                if ($array != FALSE) {
                    Template::getInstance()->array = $array;
                    Template::getInstance()->number = count($array);
                } else {
                    Template::getInstance()->number = 0;
                    Template::getInstance()->array = array();
                }
            }
            Template::getInstance()->show("group/find");
        } else {
            Template::getInstance()->show("index");
        }
    }

    public function join($groupId) {
        $error = "";
        if (isset($_SESSION["login"])) {
            $user = Database::getInstance()->getUserBySessionLogin();
            $group = Database::getInstance()->getGroupById($groupId[0]);
            if ($group != FALSE) {
                $result = Database::getInstance()->addUserToGroup($user, $group);
                if ($result) {
                    if ($group->getType() == "public") {
                        $error = "Dołączyłeś do grupy " . $group->getName();
                    } else {
                        $error = "Zapisałeś sie do grupy " . $group->getName()
                                . "<br>Jest to grupa prywatna, aby ją przeglądać musisz zostać zaakceptowany przez moderatora";
                    }
                    Template::getInstance()->message = $error;
                    Template::getInstance()->show("group/success");
                    return TRUE;
                } else {
                    $error = "Nie udało się dołączyć do grupy";
                }
            } else {
                $error = "Taka grupa nie istnieje";
            }
        } else {
            $error = "Proszę się zalogować";
        }
        Template::getInstance()->error = $error;
        Template::getInstance()->show("group/error");
        return FALSE;
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
                    Template::getInstance()->message = "Grupa została założona";
                    Template::getInstance()->show("group/success");
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

    public function show($id) {
        if (isset($_SESSION["login"])) {
            $user = Database::getInstance()->getUserBySessionLogin();
            $group = Database::getInstance()->getGroupById($id[0]);
            if ($group == FALSE) {
                $error = "Grupa nie istnieje";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            $role = Database::getInstance()->getUserRoleInGroup($user, $group);
            if ($role == "moderator" || $role == "member") {
                Template::getInstance()->group = $group;
                Template::getInstance()->posts = Database::getInstance()->getPosts($group);
                Template::getInstance()->show("group/group");
            } else {
                $error = "Nie masz dostępu do tej grupy";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
            }
        } else {
            $error = "Proszę się zalogować";
            Template::getInstance()->error = $error;
            Template::getInstance()->show("group/error");
        }
    }

    public function members($groupId) {
        if (isset($_SESSION["login"])) {
            $groupId = $groupId[0];
            $group = Database::getInstance()->getGroupById($groupId);
            if ($group == FALSE) {
                $error = "Nie znaleziono grupy";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            if (!Database::getInstance()->isSessionUserMemberOfGroup($group)) {
                $error = "Nie masz uprawnień do przeglądania członków tej grupy";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            $array = Database::getInstance()->getMembersOfGroup($group);
            if ($array == FALSE) {
                $error = "Nie znaleziono członków w tej grupie";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            Template::getInstance()->group = $group;
            Template::getInstance()->users = $array;
            Template::getInstance()->show("group/members");
        } else {
            $error = "Nie masz uprawnień do przeglądania członków tej grupy";
            Template::getInstance()->error = $error;
            Template::getInstance()->show("group/error");
        }
    }

}
