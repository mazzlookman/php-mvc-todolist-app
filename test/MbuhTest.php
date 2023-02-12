<?php

namespace Aqibmoh\PHP\MVC;

use PHPUnit\Framework\TestCase;

class MbuhTest extends TestCase
{
    public function testMbuh()
    {
        $post = "This is post";
        $_POST["post"] = $post;
        echo $_POST["post"];
    }


}