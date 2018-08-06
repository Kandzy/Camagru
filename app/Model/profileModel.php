<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 7/1/18
 * Time: 3:01 PM
 */

class profileModel
{
    public static function takeData($data)
    {
        $UserData = array();
        $UserData['UserID'] = $data[0]['UserID'];
        $UserData['Login'] = $data[0]['Login'];
        $UserData['Passwd'] = $data[0]['Passwd'];
        $UserData['Email'] = $data[0]['Email'];
        $UserData['FirstName'] = $data[0]['FirstName'];
        $UserData['LastName'] = $data[0]['LastName'];
        $UserData['Age'] = $data[0]['Age'];
        $UserData['Admin'] = $data[0]['Admin'];
        $UserData['Notification'] = $data[0]['Notification'];
        return $UserData;
    }

    public static function mailCheck($email)
    {
        if(preg_match('#(.+?)\@([a-z0-9-_]+)\.(ru|net|com|ua|tv)#i', $email))
        {
            $_SESSION['email'] = 1;
            return 1;
        }
        else
        {
            session_start();
            $_SESSION['email'] = 0;
        }
    }

    public static function changePass(){
        if (!empty($_SESSION['Login'])) {
            $user = new Profile();
            $userData = $user->getUserData();
            $oldpass = $_POST['oldpass'];

            if (hash("whirlpool", $oldpass) == $userData['Passwd']) {
                $newpass = $_POST['newpass'];
                if ($newpass == $_POST["connewpass"] && strlen($newpass) >= 8) {
                    $db = new PDOdb();
                    $db->UseDB('camagru');
                    $db->updateTableData("users", "Passwd='" . hash("whirlpool", $newpass) . "'", "Login='" . $_SESSION['Login'] . "'");
                    echo 1;
                }
                else {
                    echo 0;
                }
            } else {
                echo -1;
            }
        } else {
            header("Location:/profile/action");
        }
    }

    public static function changeLogin($db, $login, $ID)
    {
        $db->updateTableData("users", "Login='".$login."'","UserID='".$ID."'");
        $_SESSION['Login'] = $login;
    }

    public static function changeEmail($db, $Email, $ID)
    {
        echo "ok";
        $db->updateTableData("users", "Email='".$Email."'","UserID='".$ID."'");
    }

    public static function changeFirstName($db, $name, $ID)
    {
        $db->updateTableData("users", "FirstName='".$name."'","UserID='".$ID."'");
    }

    public static function changeLastName($db, $name, $ID)
    {
        $db->updateTableData("users", "LastName='".$name."'","UserID='".$ID."'");
    }

    public static function changeAge($db, $age, $ID)
    {
        $db->updateTableData("users", "Age='" . $age . "'", "UserID='" . $ID . "'");
    }

    public static function changeNotificationStatus($db, $status, $ID)
    {
        $db->updateTableData("users", "Notification='".$status."'","UserID='".$ID."'");
    }

    public static function deleteUser()
    {
        $user = new Profile();
        $userData = $user->getUserData();
        $db = new PDOdb();
        $db->UseDB('camagru');
        $db->deleteTableData('users',"UserID='".$userData['UserID']."'");
        header("Location:/login/logout");
    }
}