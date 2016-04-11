<?php
class indexController extends baseController {
    public function index() {   
        Template::getInstance()->show("index");
    }
}