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

    public function delete($postId) {
        $error = "";
        if (isset($_SESSION["login"])) {
            $user = Database::getInstance()->getUserBySessionLogin();
            $post = Database::getInstance()->getPostById($postId[0]);
            if ($post == FALSE) {
                $error = "Post nie istnieje";
            } else {
                $role = Database::getInstance()->getUserRoleInGroup($user, Database::getInstance()->getGroupById($post->getGroup()));
            }

            if (empty($error) && ($role == 'moderator' || $post->getUser() == $user->getId())) {
                if (Database::getInstance()->deletePost($post)) {
                    if (!empty($post->getImage())) {
                        unlink(IMAGE_ROOT . $post->getImage());
                    }
                } else {
                    $error = "Nie udało się usunąć postu";
                }
            } else {
                $error = "Nie masz uprawnień do usunięcia tego postu";
            }
        } else {
            $error = "Użytkownik niezalogowany";
        }
        if (empty($error)) {
            Template::getInstance()->group = Database::getInstance()->getGroupById($post->getGroup());
            Template::getInstance()->message = "Post został usunięty";
            Template::getInstance()->show("group/success");
        } else {
            Template::getInstance()->group = Database::getInstance()->getGroupById($post->getGroup());
            Template::getInstance()->error = $error;
            Template::getInstance()->show("group/error");
        }
    }

    public function edit($postId) {
        $error = "";
        if (isset($_SESSION["login"])) {
            $user = Database::getInstance()->getUserBySessionLogin();
            $post = Database::getInstance()->getPostById($postId[0]);
            if ($post == FALSE) {
                $error = "Post nie istnieje";
            }
            if (!(empty($error) && ($post->getUser() == $user->getId()))) {
                $error = "Nie masz uprawnień do edytowania tego postu";
            }
        } else {
            $error = "Użytkownik niezalogowany";
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error)) {
            $message = $_POST['message'];
            if (Database::getInstance()->updatePostMessage($post, $message)) {
                $location = APP_ROOT . "/group/show/" . $post->getGroup();
                header("Location: /$location");
            } else {
                $error = "Edycja wiadomości nie powiodła się";
            }
        } elseif (empty($error)) {
            Template::getInstance()->group = Database::getInstance()->getGroupById($post->getGroup());
            Template::getInstance()->post = $post;
            Template::getInstance()->show("post/edit");
        } else {
            Template::getInstance()->group = Database::getInstance()->getGroupById($post->getGroup());
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
            $message = $_POST['message'];
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
                $this->removeOldPosts($group);
                $location = APP_ROOT . "/group/show/" . $group->getId();
                header("Location: /$location");
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
    
    private function removeOldPosts($group){
        $posts = Database::getInstance()->getPosts($group);
        $postLimit = 50;
        $postNumber = count($posts);
        if($postNumber>=$postLimit){
            $i=$postLimit-1;
            while($i<$postNumber-1){
                $image = $posts[$i]->getImage();
                if(!empty($image)){
                    unlink(IMAGE_ROOT . $image);                    
                }
                Database::getInstance()->deletePost($posts[$i]);
                $i++;
            }
            
        }
    }
}
