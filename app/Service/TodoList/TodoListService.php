<?php

namespace Aqibmoh\PHP\MVC\Service\TodoList;

use Aqibmoh\PHP\MVC\Model\TodoListRequest;
use Aqibmoh\PHP\MVC\Model\TodoListResponse;

interface TodoListService
{
    public function create(TodoListRequest $request):TodoListResponse;

    public function update(TodoListRequest $request):TodoListResponse;

    public function findByID(int $id):?TodoListResponse;

    public function findByUserID(int $id):array;

    public function deleteByID(int $id):int;
}