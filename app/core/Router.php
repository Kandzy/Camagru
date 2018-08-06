<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/12/18
 * Time: 3:25 PM
 */

class Router
{
    static function start()
    {
        $controller_name = "main";
        $action_name = "action";

        $rout = explode('/', $_SERVER['REQUEST_URI']);

        if(!empty($rout[1]))
        {
            $controller_name = $rout[1];
        }
        if (!empty($rout[2])) {
            $getrout = explode('?', $rout[2]);
        }
        if(!empty($getrout[0]))
        {
            $action_name = $getrout[0];
        }
        $model_name = $controller_name;
        $model_path = "app/Model/".$model_name."Model.php";
        $controller_path = "app/Controller/".$controller_name.".php";
        if (file_exists($model_path))
        {
            include $model_path;
        }
        if (file_exists($controller_path))
        {
            include $controller_path;
        }
        else {
            echo "<div style='width: 100%; display: flex; flex-direction: column; align-content: center; align-items: center; justify-content: center;'>
                    <h1 style='font-size: 5vw'>Эту страницу не видишь ты... Походу</h1>
                    <img style='width: 40vw; height: 40vw' src='../../src/PageNotFound.png'>
                    <h1 style='font-size: 3vw'>Error 404: страница не найдена.</h1>
                    </div>";
        }
        $controller = new $controller_name;
        if (method_exists($controller, $action_name))
        {
            if (isset($getrout[1])) {
                $controller->$action_name($getrout[1]);
            } else {
                $controller->$action_name();
            }
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
}