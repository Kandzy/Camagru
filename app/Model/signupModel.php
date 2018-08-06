<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/15/18
 * Time: 1:19 PM
 */

class signupModel
{
    public static function register()
    {
        if (signupModel::mailCheck($_POST['email']) && signupModel::checkPassword($_POST['passwd'], $_POST['conf_pass'])) {
            if (!signupModel::addUser($_POST['login'], $_POST['passwd'], $_POST['email'])) {
                echo 0;
            } else {
                echo 1;
            }
        } else {
            echo -1;
        }
        if (!isset($_POST['email']) || !isset($_POST['login']) || !isset($_POST['passwd'])) {
            header("Location:/signup/action");
        }
    }

    public static function userExist()
    {
        $db = new PDOdb();
        $db->UseDB("camagru");
        if (!$db->findUserData("users", "Login", "Login='".$_POST['login']."'") && !$db->findUserData("confirmation", "Login", "Login='".$_POST['login']."'")) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public static function emailExist()
    {
        $db = new PDOdb();
        $db->UseDB("camagru");
        if (!$db->findUserData("users", "Login", "Email='".$_POST['email']."'") && !$db->findUserData("confirmation", "Login", "Email='".$_POST['email']."'")) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public static function addUser($login, $pass, $email)
    {
        $db = new PDOdb();
        $db->UseDB("camagru");
        $hash = hash('md5', $email);
        if (!$db->findUserData("users", "Login", "Login='".$login."'") && !$db->findUserData("users", "Email", "Email='".$email."'")) {
            if($db->addTableData("confirmation", "Login, Passwd, Email, Admin, hash", "'" . $login . "','" . hash("whirlpool", $pass) . "','" . $email . "', 1,'".$hash."'"))
            {
                self::mail($hash);
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }

    public static function emailConf($hash){
        $db = new PDOdb();
        $db->UseDB("camagru");
        if ($userData = $db->findUserData("confirmation", "Login, Passwd, Email, Admin, hash", "hash='".$hash."'"))
        {
            if ($db->addTableData("users", "Login, Passwd, Email, Admin", "'" . $userData[0]["Login"] . "','" .$userData[0]["Passwd"]. "','" . $userData[0]["Email"] . "','".$userData[0]["Admin"]."'"))
            {
                $db->deleteTableData("confirmation", "hash='".$hash."'");
                return 1;
            }
        }
        else
        {
            return 0;
        }
    }

    public static function mailCheck($email)
    {
        if(preg_match('#(.+?)\@([a-z0-9-_]+)\.(ru|net|com|ua|tv)#i', $email))
        {
            return (1);
        }
        else
        {
            return (0);
        }
    }

    public static function checkRegexPass($Password){
        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$#', $Password))
        {
            return (1);
        }
        else{
            return (0);
        }
    }

    public static function checkPassword($Password, $ConfirmPassword)
    {
        if (strlen($Password) < 8)
        {
            $_SESSION['password'] = -1;
            return 0;
        }
        if ($Password == $ConfirmPassword)
        {
            return signupModel::checkRegexPass($Password);
        }
        else
        {
            $_SESSION['password'] = 0;
            return 0;
        }
    }

    public static function mail($hash)
    {
        $db = new PDOdb();
        $db->UseDB("camagru");
        $user = $db->findUserData("confirmation", "Login,Email", "hash='".$hash."'");
        $encoding = "utf-8";
        $mail_to = $user[0]["Email"];
        $mail_subject = "Sign UP Camagru";
        $mail_message = "<div style='font-size:10pt; font-style:italic; color:#006699;'>Здравствуйте, ". $user[0]["Login"].",
                Спасибо за регистрацию учётной записи! Прежде чем мы начнем, нам нужно убедиться, что это Вы. Нажмите ниже, чтобы подтвердить свой адрес электронной почты:<br/>
        
        <a href='http://localhost:8100/signup/emailConfirm?UID=".$hash."'><button style='outline: none;
                        height: 1.7em;
                        width: 10em;
                        font-size: 2vw;
                        border-radius:  0.5vw;
                        color: white;
                        background-color: #08558b;'>Подтвердить e-mail</button></a></div>";
        $from_name = "DK";
        $from_mail = "dkunitcorp@gmail.com";
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: ".$from_name." <".$from_mail."> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";

        if (mail($mail_to, $mail_subject, $mail_message, $header))
        {

        }
        else{
            echo "error";
        }
    }
}