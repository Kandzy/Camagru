<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/13/18
 * Time: 12:07 PM
 */

class LoginModel extends PDOdb
{
    private $connect;
    public function __construct()
    {
        parent::__construct();
        $this->connect = new PDOdb();
    }

    public function findUser($login, $passwd)
    {
        $this->connect->UseDB('camagru');
        if($this->connect->findUserData('users', 'Login, Passwd', "Login='".$login."' AND Passwd='".$passwd."'"))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}