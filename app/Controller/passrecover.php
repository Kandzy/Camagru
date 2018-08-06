<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 7/10/18
 * Time: 12:50 PM
 */

class passrecover extends Controller
{
    function action(){
        if (!empty($_POST)) {
            $login = $_POST['login'];
            $email = $_POST['email'];

            $db = new PDOdb();
            $db->UseDB("camagru");
            $data = $db->findUserData("users", "UserID", "Login='" . $login . "' AND Email='" . $email . "'");
            if (!empty($data)) {
                $encoding = "utf-8";
                $mail_to = $email;
                $mail_subject = "Password recovering";
                $mail_message = "<div style='font-size:10pt; font-style:italic;'><a href='http://localhost:8100/passrecover/droppassword?login=" . $login . "&action=" . hash("md5", $login . $email) . "'>Click here to drop your password !</a></div>";
                $from_name = "DK";
                $from_mail = "dkunitcorp@gmail.com";
                $header = "Content-type: text/html; charset=" . $encoding . " \r\n";
                $header .= "From: " . $from_name . " <" . $from_mail . "> \r\n";
                $header .= "MIME-Version: 1.0 \r\n";
                $header .= "Content-Transfer-Encoding: 8bit \r\n";
                $header .= "Date: " . date("r (T)") . " \r\n";

                if (mail($mail_to, $mail_subject, $mail_message, $header)) {
                    echo 1;
                } else {
                    echo -1;
                }
            } else {
                echo 0;
            }
        }
        else{
            header("Location:/profile/changepassword");
        }
    }

    public function droppassword()
    {
        if (empty($_SESSION['Login'])) {
            $hash = $_GET["action"];
            $login = $_GET['login'];
            View::generate("app/View/passrecover.phtml", "template.phtml");
            echo "<input type='hidden' name='$login' value='$hash' id='userData'>";
        }
        else {
            header("Location:/profile/changepassword");
        }
    }

    public function finish_recover()
    {
        if (!empty($_POST)) {
            if ($_POST['pass1']) {
                $hash = $_POST["act"];
                $login = $_POST['login'];
                $db = new PDOdb();
                $db->UseDB("camagru");
                $data = $db->findUserData("users", "Email", "Login='" . $login . "'");
                if ($hash == hash('md5', $login . $data[0]['Email'])) {
                    if ($this->checkPassword($_POST['pass1'], $_POST['pass2'])) {
                        $db->updateTableData('users', "Passwd='" . hash("whirlpool", $_POST['pass1']) . "'", "Login='" . $login . "'");
                        echo 1;
                    } else {
                        echo -2;
                    }
                } else {
                    echo -1;
                }
            } else {
                echo 0;
            }
        }
        else{
            echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Эту страницу не видишь ты... Походу</h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error 404: страница не найдена.</h1>
                    </div>";
        }
    }

    private function checkRegexPass($Password)
    {
            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$#', $Password)) {
                return (1);
            } else {
                return (0);
            }
    }

    private function checkPassword($Password, $ConfirmPassword)
    {
        if (strlen($Password) < 8)
        {
            $_SESSION['password'] = -1;
            return 0;
        }
        if ($Password == $ConfirmPassword)
        {
            return $this->checkRegexPass($Password);
        }
        else
        {
            $_SESSION['password'] = 0;
            return 0;
        }
    }
}