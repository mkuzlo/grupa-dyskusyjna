<?php
/**
 * Description of Posts
 *
 * @author Mateusz Kuzło
 */
class Posts {
    private $id;
    private $user;
    private $group;
    private $message;
    private $image;
    private $date;
    
    public function getId() {
        return $this->id;
    }

    public function getUser() {
        return $this->user;
    }

    public function getGroup() {
        return $this->group;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getImage() {
        return $this->image;
    }

    public function getDate() {
        return $this->date;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setGroup($group) {
        $this->group = $group;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setDate($date) {
        $this->date = $date;
    }
}
