<?php
/**
 * Created by PhpStorm.
 * User: dkliukin
 * Date: 6/12/18
 * Time: 2:05 PM
 */

class View
{

    static function generate($content_view, $template_view, $data = null)
    {

        include 'app/View/'.$template_view;

    }
}