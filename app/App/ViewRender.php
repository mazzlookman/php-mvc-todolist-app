<?php

namespace Aqibmoh\PHP\MVC\App;

class ViewRender
{
    public static function render(string $view, $model):void{
        require_once __DIR__ . "/../View/header.php";
        require_once __DIR__ . "/../View/" . $view;
        require_once __DIR__ . "/../View/footer.php";
    }

    public static function redirect(string $url):void{
        header("Location:$url");
        exit();
    }
}