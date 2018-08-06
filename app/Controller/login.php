<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.06.2018
 * Time: 18:16
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

require_once "app/Model/loginModel.php";
class Login extends Controller {
    function action()
    {
        if (empty($_SESSION['Login'])) {
            $_SESSION['Login'] = "";
            View::generate('app/View/login.phtml', 'template.phtml');
        }
        else
        {
            header("Location:/");
        }
    }

    function checkLog()
    {
        if (empty($_SESSION['Login'])) {

            if (isset($_POST['login']) && isset($_POST['passwd'])) {
                $login = $_POST['login'];
                $password = hash("whirlpool", $_POST['passwd']);
                $user = new LoginModel();
                if (empty($login) || empty($password)) {
                    $_SESSION['Login'] = "";
                    echo 2;
                }
                if ($user->findUser($login, $password)) {
                    $_SESSION['Login'] = $login;
                    echo 1;
                } else {
                    echo 0;
                    $_SESSION['Login'] = "";
                }
            }
            if (!isset($_POST['login']) || !isset($_POST['passwd']))
            {
                header("Location:/login/action");
            }
        }
        else {
            header("Location:/login/action");
        }
    }

    public static function logout()
    {
        $_SESSION['Login'] = "";
        header("Location:/login/action");
    }


    public static function passrecovering()
    {
        if(empty($_SESSION["Login"])) {
            View::generate('app/View/recover.phtml', 'template.phtml');
        }
        else{
            header("Location:/profile/changepassword");
        }
    }
}