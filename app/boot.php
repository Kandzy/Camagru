<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/12/18
 * Time: 4:26 PM
 */
session_start();



require_once "core/PDOdb.php";
require_once "core/View.php";
require_once "core/Controller.php";
require_once "core/Router.php";

Router::start();

