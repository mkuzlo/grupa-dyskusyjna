<?php
class indexController extends BaseController {
    public function index() {   
        Template::getInstance()->show("index");
    }
}