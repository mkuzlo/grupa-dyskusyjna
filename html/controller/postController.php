<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of postController
 *
 * @author Mateusz Kuzło
 */
class postController extends baseController {

    public function index() {
        Template::getInstance()->show("index");
    }

    public function create($groupId) {
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
                $error = "Nie masz uprawnień do dodawanie postów w tej grupie";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            Template::getInstance()->group = $group;
            Template::getInstance()->show("post/create");
        } else {
            $error = "Nie masz uprawnień do dodawanie postów w tej grupie";
            Template::getInstance()->error = $error;
            Template::getInstance()->show("group/error");
        }
    }

    public function add($groupId) {
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
                $error = "Nie masz uprawnień do dodawanie postów w tej grupie";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            Template::getInstance()->group = $group;
            $message = trim($_POST['message']);
            if (strlen($message) > 2000) {
                Template::getInstance()->error = "Wiadomość zbyt długa";
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            $filename = $_FILES['file']['name'];
            if (empty($filename) && empty($message)) {
                Template::getInstance()->error = "Wiadomość jest pusta";
                Template::getInstance()->show("group/error");
                return FALSE;
            }
            if (empty($filename)) {
                $post = new Posts();
                $post->setUser(Database::getInstance()->getUserBySessionLogin()->getId());
                $post->setMessage($message);
                $post->setGroup($group->getId());
                $post->setImage("");
                $post->setDate(date("Y-m-d H:i:s"));
                $result = Database::getInstance()->addPost($post);
            } else {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $allowed = array('gif', 'png', 'jpg', 'jpeg');
                if (!in_array($ext, $allowed)) {
                    Template::getInstance()->error = "Niedozwolony typ pliku: " . $ext;
                    Template::getInstance()->show("group/error");
                    return FALSE;
                }
                $image = rand(10000, 30000) . "" . rand(10000, 30000) . "" . rand(10000, 30000) . "." . $ext;
                $file = IMAGE_ROOT . $image;
                while (file_exists($file)) {
                    $image = rand(10000, 30000) . "" . rand(10000, 30000) . "" . rand(10000, 30000) . "." . $ext;
                    $file = IMAGE_ROOT . $image;
                }
                $size = $_FILES['file']['size'];
                if ($size > 1000000) {
                    Template::getInstance()->error = "Plik zbyt duży, maksymalny rozmiar to 1MB";
                    Template::getInstance()->show("group/error");
                    return FALSE;
                }
                $result = move_uploaded_file($_FILES['file']['tmp_name'], $file);
                if ($result == FALSE) {
                    Template::getInstance()->error = "Nie udało się wysłać plik";
                    Template::getInstance()->show("group/error");
                    return FALSE;
                }
                $post = new Posts();
                $post->setUser(Database::getInstance()->getUserBySessionLogin()->getId());
                $post->setMessage($message);
                $post->setGroup($group->getId());
                $post->setImage($image);
                $post->setDate(date("Y-m-d H:i:s"));
                $result = Database::getInstance()->addPost($post);
            }
            if ($result == TRUE) {
                Template::getInstance()->show("group/group");
            } else {
                $error = "Nie udało się dodać postu";
                Template::getInstance()->error = $error;
                Template::getInstance()->show("group/error");
            }
        } else {
            $error = "Nie masz uprawnień do dodawanie postów w tej grupie";
            Template::getInstance()->error = $error;
            Template::getInstance()->show("group/error");
        }
    }

}
