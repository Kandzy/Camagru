<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/13/18
 * Time: 2:38 PM
 */

class mainModel extends PDOdb
{
    public static function addComment()
    {
        if (!empty($_POST['text'])) {
            $db = new PDOdb();
            $db->UseDB("camagru");
            //        $db->addTableColumn("Comments", "UserName", "varchar(100)");
            $data = $db->findUserData("users", "UserID", "Login='" . $_SESSION["Login"] . "'");
            $Photo = $db->findUserData("pictures", "UserID", "PicID='".$_POST['PID']."'");
            $User = $db->findUserData("users", "Notification, Email", "UserID='" . $Photo[0]['UserID'] . "'");
            $_POST['text'] = str_replace("'", "\'", $_POST['text']);
            $db->addTableData("comments", "UserID, UserName, PicID, text", "'" . $data[0]["UserID"] . "','" . $_SESSION['Login'] . "','" . $_POST['PID'] . "','" . $_POST['text'] . "'");
            if ($User[0]['Notification'] && $_SESSION['Login'] != "")
            {
                $encoding = "utf-8";
                $mail_to = $User[0]["Email"];
                $mail_subject = "New message";
                $mail_message = "<div style='font-size:10pt; font-style:italic; color:#006699;'>You have received a new message from ".$_SESSION['Login']."!</div>";
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

                }
            }
        }
    }

    public static function gallery()
    {
        $db = new PDOdb();
        $from = intval($_POST['from']);
        $db->UseDB("camagru");

        $numofpic = $db->findUserData("pictures", "COUNT(*)", "1=1");
        $pictures = $numofpic[0]['COUNT(*)'];
        if ($pictures - $from >= 5)
        {
            $to = 5;
        }else
        {
            $to = $pictures - $from;
        }
        $data = $db->findUserData("pictures", "PicID, url", "1=1 ORDER BY data DESC LIMIT ".$from.", ".$to);
        echo json_encode($data);
    }

    public static function commentField()
    {
        $db = new PDOdb();
        $db->UseDB("camagru");

        $data = $db->findUserData("comments", "UserID, text, data, UserName", "PicID='".$_POST["PicID"]."'");

        foreach ($data as $k=>$v)
        {
            echo $v['UserName'].$v['UserID']." ".$v['data']." said:".$v['text']."&";
        }
    }

    public static function likes($modif)
    {
        $db = new PDOdb();
        $db->UseDB('camagru');
        $data = $db->findUserData("users", "UserID", "Login='".$_SESSION['Login']."'");
        if ($modif == 1) {
            if (!$db->findUserData('likes', "LikeID", "UserID=" . $data[0]['UserID'] . " AND Target=" . $_POST['PID'])) {
                $db->addTableData('likes', "UserID, Target", $data[0]['UserID'] . ", " . $_POST['PID']);
                $likes = $db->findUserData("likes", "COUNT(*)", "Target='".$_POST['PID']."'");
                $db->updateTableData("pictures", "Likes='".$likes[0]['COUNT(*)']."'", "PicID='".$_POST['PID']."'");
                echo $likes[0]['COUNT(*)']."|1";
            } else {
                $db->deleteTableData('likes', "UserID=" . $data[0]["UserID"] . " AND Target=" . $_POST['PID']);
                $likes = $db->findUserData("likes", "COUNT(*)", "Target='".$_POST['PID']."'");
                $db->updateTableData("pictures", "Likes='".$likes[0]['COUNT(*)']."'", "PicID='".$_POST['PID']."'");
                echo $likes[0]['COUNT(*)']."|0";
            }
        }
        if ($modif == 2) {
            $likes = $db->findUserData("likes", "COUNT(*)", "Target='".$_POST['PID']."'");
            $Like = $db->findUserData('likes', "LikeID", "UserID='".$data[0]["UserID"]."' AND Target='".$_POST['PID']."'");
            if (!empty($Like))
            {

                echo $likes[0]['COUNT(*)']."|1";
            }
            else
            {
                echo $likes[0]['COUNT(*)']."|0";
            }
        }
    }
}