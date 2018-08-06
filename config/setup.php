<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/10/18
 * Time: 2:49 PM
 */

require_once "app/core/PDOdb.php";

$db = new PDOdb();
if($db->createDataBase("Camagru")) {
    $db->UseDB("Camagru");

    /**
     * User Table creation
     */

    $db->createTable("Users", "UserID");
    $db->addTableColumn("Users", "Login", "varchar(100) NOT NULL UNIQUE");
    $db->addTableColumn("Users", "Passwd", "varchar(10000)");
    $db->addTableColumn("Users", "Email", "varchar(100) NOT NULL UNIQUE");
    $db->addTableColumn("Users", "FirstName", "varchar(100)");
    $db->addTableColumn("Users", "LastName", "varchar(100)");
    $db->addTableColumn("Users", "Age", "varchar(100)");
    $db->addTableColumn("Users", "Admin", "varchar(100)");
    $db->addTableColumn("Users", "Notification", "varchar(1) DEFAULT '1'");


    /**
     * Photo Table creation
     */

    $db->createTable("Pictures", "PicID");
    $db->addTableColumn("Pictures", "UserID", "INT(11)");
    $db->addTableColumn("Pictures", "url", "varchar(500)");
    $db->addTableColumn("Pictures", "Likes", "INT(10)");
    $db->addTableColumn("Pictures", "Private", "INT(10)");
    $db->addTableColumn("Pictures", "data", "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");

    /**
     * Temp users
     */

    $db->createTable("confirmation", "UID");
    $db->addTableColumn("confirmation", "Login", "varchar(100) NOT NULL UNIQUE");
    $db->addTableColumn("confirmation", "Passwd", "varchar(10000)");
    $db->addTableColumn("confirmation", "Email", "varchar(100) NOT NULL UNIQUE");
    $db->addTableColumn("confirmation", "FirstName", "varchar(100)");
    $db->addTableColumn("confirmation", "LastName", "varchar(100)");
    $db->addTableColumn("confirmation", "Age", "varchar(100)");
    $db->addTableColumn("confirmation", "Admin", "varchar(100)");
    $db->addTableColumn("confirmation", "Notification", "varchar(1) DEFAULT '1'");
    $db->addTableColumn("confirmation", "hash", "varchar(256)");
    /**
     * Likes Table creation
     */

    $db->createTable("Likes", "LikeID");
    $db->addTableColumn("Likes","UserID", "varchar(10)");
    $db->addTableColumn("Likes","Target", "varchar(256)");

    /**
     * Comments Table Creation
     */

    $db->createTable("Comments", "ComID");
    $db->addTableColumn("Comments", "UserID", "INT(11)");
    $db->addTableColumn("Comments", "UserName", "varchar(100)");
    $db->addTableColumn("Comments", "PicID", "INT(11)");
    $db->addTableColumn("Comments", "text", "varchar(1000)");
    $db->addTableColumn("Comments", "data", "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");

    /**
     * Preloaded
     */

    $db->createTable("Preloaded", "PicID");
    $db->addTableColumn("Preloaded", "url", "varchar(500)");
    $db->addTableColumn("Preloaded", "data", "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
    $db->addTableData('Preloaded', "url", "'src/preloaded/1.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/2.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/3.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/4.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/5.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/6.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/7.png'");
    $db->addTableData('Preloaded', "url", "'src/preloaded/8.png'");
}