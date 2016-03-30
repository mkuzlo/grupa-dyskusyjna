<?php
/**
 * Description of UserGroups
 *
 * @author Mateusz Kuzło
 */
class UserGroups {
    private $id;
    private $user;
    private $group;
    private $role;
    
    public function getId() {
        return $this->id;
    }

    public function getUser() {
        return $this->user;
    }

    public function getGroup() {
        return $this->group;
    }

    public function getRole() {
        return $this->role;
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

    public function setRole($role) {
        $this->role = $role;
    }
}
