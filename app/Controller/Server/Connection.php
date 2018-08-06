<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/10/18
 * Time: 2:34 PM
 */


class Connection
{
    protected $PDOConnect;

    public function __construct()
    {
        try {
            include($_SERVER["DOCUMENT_ROOT"]."/config/database.php");
            $this->PDOConnect = new PDO($_SERVER['DB_DSN'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], NULL);
            $this->PDOConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $ex){
            echo "Connection failed: ".$ex->getMessage()."</br>";
        }
    }

    public function get_connection()
    {
        return $this->PDOConnect;
    }

    public function disconnect()
    {
        $this->PDOConnect = NULL;
    }
}