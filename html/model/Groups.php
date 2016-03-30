<?php
/**
 * Description of Groups
 *
 * @author Mateusz Kuzło
 */
class Groups {
    private $id;
    private $name;
    private $description;
    private $type;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getType() {
        return $this->type;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setType($type) {
        $this->type = $type;
    }
}
