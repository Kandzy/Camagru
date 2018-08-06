<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.06.2018
 * Time: 18:01
 */

class Controller {

    public $model;
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

    function action()
    {
        // todo
    }
}