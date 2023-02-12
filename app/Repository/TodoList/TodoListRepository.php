<?php

namespace Aqibmoh\PHP\MVC\Repository\TodoList;

use Aqibmoh\PHP\MVC\Domain\TodoList;

interface TodoListRepository
{
    public function save(TodoList $todoList):TodoList;

    public function findByID(int $id):?TodoList;

    public function findAll(int $userID):array;

    public function update(TodoList $todoList):TodoList;

    public function deleteByID(int $id):int;

    public function deleteAll():int;
}