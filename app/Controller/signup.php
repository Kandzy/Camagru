<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.06.2018
 * Time: 18:17
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

require_once "app/Model/signupModel.php";

class Signup extends Controller
{
    private $db;
    function action()
    {
        parent::action();
        if (empty($_SESSION['Login'])) {
            $_SESSION["register"] = 1;
            $_SESSION['email'] = 1;
            $_SESSION['password'] = 1;
            View::generate("app/View/signup.phtml", "template.phtml");
        }
        else
        {
            header("Location:/");
        }
    }

    public function userExist()
    {
        if (!empty($_POST['login'])) {
            signupModel::userExist();
        }
        else{
            echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Эту страницу не видишь ты... Походу</h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error 404: страница не найдена.</h1>
                    </div>";
        }
    }

    public function emailExist()
    {
        if (!empty($_POST['email'])) {
            signupModel::emailExist();
        }
        else
        {
                echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Эту страницу не видишь ты... Походу</h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error 404: страница не найдена.</h1>
                    </div>";
        }
    }


    public function register()
    {
        if(!empty($_POST)) {
            signupModel::register();
        }
        else{
            echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Эту страницу не видишь ты... Походу</h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error 404: страница не найдена.</h1>
                    </div>";
        }
    }

    public function emailConfirm()
    {
        if (signupModel::emailConf($_GET["UID"])) {
            header("Location:/");
        } else {
            echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Юзера такого не видим мы... Undefined судьба его ... </h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error: User Not Found.</h1>
                    </div>";
        }
    }
}