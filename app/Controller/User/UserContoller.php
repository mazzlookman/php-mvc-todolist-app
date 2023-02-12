<?php

namespace Aqibmoh\PHP\MVC\Controller\User;

interface UserContoller
{
    public function loginPage():void;

    public function postLogin():void;

    public function logout():void;

    public function registerPage():void;

    public function postRegister():void;

    public function workSpace():void;

}