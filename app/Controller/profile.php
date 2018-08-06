<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.06.2018
 * Time: 18:05
 */
/**
 * $_SESSOIN['Login'] - login of current user
 * If $_SESSION['Login'] = "" - no users logged in. Optional "";
 *
 * $_SESSION['register'] - if empty - user exist and cant create:
 * $_SESSION['register'] = 0 - User Already exist
 * $_SESSION['register'] = 1 - optional value
 * $_SESSION['register'] = 2 - user registration finished (All ok)
 *
 * $_SESSION['email'] - check if user put right email in field:
 * $_SESSION['email'] = 0 - Address cant be rigth. User mistake. Need re-enter email
 * $_SESSION['email'] = 1 - optional value. If user type right email this value doesn't change
 *
 * $_SESSION['password'] - check if password right:
 * $_SESSION['password'] = 0 - PASSWORD and CONFIRM PASSWORD do not match.
 * $_SESSION['password'] = -1 - Password has less than 8 symdols
 * $_SESSION['password'] = 1 - optional password value
 *
 * $_SESSION['LoginTry'] - if value equal 0 user first time enter login/password. If value equal 1 user already failed
 * login and re-enter log/pass. Optional 0;
 *
 * $userData['Login'] - user login
 * $userData['Password'] - user pass
 * $userData['Email'] - user Email
 * $userData['UserID'] - User ID
 * $userData['FirstName'] - User First name
 * $userData['LastName'] - User Last Name
 * $userData['Age'] - User Age
 * $userData['Admin status'] - user admin status - 0 no admin status 1 admin status
 */

class Profile extends Controller
{
    private static $UserData;
    private static $ChangePass = FALSE;

    public function action()
    {
        if (!empty($_SESSION['Login'])) {
            $db = new PDOdb();
            $db->UseDB('camagru');
            $data = $db->findUserData('users', "UserID, Login, Passwd, Email, FirstName, LastName, Age, Admin, Notification", "Login='" . $_SESSION['Login'] . "'");
            self::$UserData = profileModel::takeData($data);
            View::generate("app/View/profile.phtml", "template.phtml");
        } else {
            header("Location:/login/action");
        }
    }

    public function updates()
    {
        if ($_SESSION['Login'] != "") {
            View::generate("app/View/profileUpdate.phtml", "template.phtml");
        }
        else
        {
            header('Location:/login');
        }
    }

    public function changepassword()
    {
        if ($_SESSION['Login']) {
            View::generate("app/View/profileChangePass.phtml", "template.phtml");
        }
        else
        {
            header("Location:/login");
        }
    }

    public function addPicture()
    {
        View::generate("app/View/addpicture.phtml", "template.phtml");
    }

    public function uploadPicture()
    {
        $uploaddir = 'src/';
        if ($_FILES['photoloader']['name'] != "") {
            $uploadfile = $uploaddir . basename($_FILES['photoloader']['name']);
            echo $uploadfile;

            echo '<pre>';
            if (move_uploaded_file($_FILES['photoloader']['tmp_name'], "$uploadfile")) {
                echo "Файл корректен и был успешно загружен.\n";
            } else {
                echo "Возможная атака с помощью файловой загрузки!\n";
            }
            $db = new PDOdb();
            $db->UseDB("camagru");
            $data = $db->findUserData("users", "UserID", "Login='" . $_SESSION['Login'] . "'");
            $db->addTableData("pictures", "UserID, url, Likes, Private", "'" . $data[0]["UserID"] . "','" . $uploadfile . "','0','0'");
        }
        header("Location:/profile");
    }

    public function ChangePass()
    {
        self::$ChangePass = TRUE;
        View::generate("app/View/profile.phtml", "template.phtml");
    }

    public function getUserData()
    {

        $db = new PDOdb();
        $db->UseDB('camagru');

        $data = $db->findUserData('users', "UserID, Login, Passwd, Email, FirstName, LastName, Age, Admin, Notification", "Login='" . $_SESSION['Login'] . "'");
        self::$UserData = profileModel::takeData($data);
        return self::$UserData;
    }

    public static function ConfirmChangePassword()
    {
        if (!empty($_POST)) {
            profileModel::changePass();
        }
        else {
            echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Эту страницу не видишь ты... Походу</h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error 404: страница не найдена.</h1>
                    </div>";
        }
    }

    public function update()
    {
        $user = new Profile();
        $db = new PDOdb();
        $db->UseDB('camagru');
        $userData = $user->getUserData();
        $ID = $userData['UserID'];
        if(!empty($_POST['Login'])) {
            if ($userData['Login'] != $_POST['Login'] && !$db->findUserData('users', 'Login', "Login='" . $_POST['Login'] . "'")) {
                profileModel::changeLogin($db, $_POST['Login'], $ID);
            }
            if ($userData['Email'] != $_POST['Email'] && !$db->findUserData('users', 'Email', "Login='" . $_POST['Email'] . "'") && profileModel::mailCheck($_POST['Email'])) {
                profileModel::changeEmail($db, $_POST['Email'], $ID);
            }
            if ($userData['FirstName'] != $_POST['Name']) {
                profileModel::changeFirstName($db, $_POST['Name'], $ID);
            }
            if ($userData['LastName'] != $_POST['Surname']) {
                profileModel::changeLastName($db, $_POST['Surname'], $ID);
            }
            if ($userData['Age'] != $_POST['Age']) {
                profileModel::changeAge($db, $_POST['Age'], $ID);
            }
            if (isset($_POST['Notification'])) {
                profileModel::changeNotificationStatus($db, 1, $ID);
            } else {
                profileModel::changeNotificationStatus($db, 0, $ID);
            }
            header("Location:/profile/action");
        }
        header("Location:/profile/action");
    }

    public function deleteUser()
    {
        profileModel::deleteUser();
    }

    public function showGallery(){
        $db = new PDOdb();
        $from = intval($_POST['from']);
        $db->UseDB("camagru");
        $numofpic = $db->findUserData("pictures", "COUNT(*)", "1=1");
        $user = $db->findUserData("users", "UserID", "Login='".$_SESSION['Login']."'");
        $pictures = $numofpic[0]['COUNT(*)'];
        if ($pictures - $from >= 5)
        {
            $to = 5;
        }else
        {
            $to = $pictures - $from;
        }
        $data = $db->findUserData("pictures", "PicID, url", "UserID='".$user[0]['UserID']."' ORDER BY data DESC LIMIT ".$from.", ".$to);
        echo json_encode($data);
    }

    public function checkUpdatedData(){
        $db = new PDOdb();
        $db->UseDB("camagru");
        $data = $db->findUserData("users", "*", "Login='".$_POST['login']."'");
        if ($_POST['login'] != $_SESSION['Login'] && ($data))
        {
            echo 0;
            return ;
        }
        else if ($_POST['email'] != $data[0]['Email'])
        {
            if ($db->findUserData("users", "*", "Email='".$_POST['email']."'"))
            {
                echo -1;
                return ;
            }
        }
        echo 1;
    }

    public function delPicture()
    {
        $PID = $_POST['PID'];
        $db = new PDOdb();
        $db->UseDB("camagru");

        $user = $db->findUserData("users", "UserID", "Login='".$_SESSION['Login']."'");
        if ($db->findUserData('pictures', "*", "UserID='".$user[0]['UserID']."' AND PicID='".$PID."'"))
        {
            $db->deleteTableData("pictures", "UserID='".$user[0]['UserID']."' AND PicID='".$PID."'");
        }
    }
}
