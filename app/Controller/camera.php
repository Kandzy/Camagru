<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 7/14/18
 * Time: 6:25 PM
 */

class camera
{
    public function action()
    {
        if ($_SESSION['Login'] != "") {
            View::generate("app/View/addpicture.phtml", "template.phtml");
        }
        else{
            header("Location:/login");
        }
    }

    public function saveImg()
    {
        $img = $_POST['image'];
        print_r($img);
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = "src/".md5($data).".png";
        file_put_contents($file, $data);
        $db = new PDOdb();
        $db->UseDB("camagru");
        $user = $db->findUserData("users", "UserID", "Login='".$_SESSION['Login']."'");
        $db->addTableData("pictures", "UserID, url, Likes, Private", "'".$user[0]["UserID"]."','".$file."','0','0'");
    }

    public function CamShowGallery(){
        $db = new PDOdb();
        $from = intval($_POST['from']);
        $db->UseDB("camagru");
        $numofpic = $db->findUserData("preloaded", "COUNT(*)", "1=1");
        $pictures = $numofpic[0]['COUNT(*)'];
        if ($pictures - $from >= 5)
        {
            $to = 5;
        }else
        {
            $to = $pictures - $from;
        }
        $data = $db->findUserData("preloaded", "PicID, url",  "1=1 LIMIT ".$from.", ".$to);
        echo json_encode($data);
    }
}