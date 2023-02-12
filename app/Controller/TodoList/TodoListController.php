<?php

namespace Aqibmoh\PHP\MVC\Controller\TodoList;

interface TodoListController
{
    public function postCreate():void;

    public function update():void;

    public function postUpdate():void;

    public function postDeleteByID():void;
}