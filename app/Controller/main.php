<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/13/18
 * Time: 2:37 PM
 */

class main extends Controller
{
    public function action()
    {
        parent::action();
        View::generate("app/View/main.phtml", "template.phtml");
    }

    public function addComment()
    {
        if (!empty($_POST['text'])) {
            mainModel::addComment();
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

    public function showGallery(){
        if (!empty($_POST['to'])) {
            mainModel::gallery();
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

    public function FillComment(){
        if (!empty($_POST)) {
            mainModel::commentField();
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

    public function addLike(){
        mainModel::likes(1);
    }

    public function checkLike()
    {
        mainModel::likes(2);
    }
}
