<?php

namespace Aqibmoh\PHP\MVC\Controller;

use Aqibmoh\PHP\MVC\App\ViewRender;

class HomeController
{
    public function home():void{
        ViewRender::render(
            "Home/home.php",
            ["title"=>"Halo Home"]
        );
    }
}