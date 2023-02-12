<?php

namespace Aqibmoh\PHP\MVC\Service\TodoList;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\TodoList;
use Aqibmoh\PHP\MVC\Exception\ValidationException;
use Aqibmoh\PHP\MVC\Model\TodoListRequest;
use Aqibmoh\PHP\MVC\Model\TodoListResponse;
use Aqibmoh\PHP\MVC\Repository\TodoList\TodoListRepository;

class TodoListServiceImpl implements TodoListService
{
    private TodoListRepository $todoListRepository;

    public function __construct(TodoListRepository $todoListRepository)
    {
        $this->todoListRepository = $todoListRepository;
    }

    public function create(TodoListRequest $request): TodoListResponse
    {
        $this->validationCreateTodoListRequest($request);

        $todoList = new TodoList();
        $todoList->userID = $request->userID;
        $todoList->title = $request->title;
        $todoList->content = $request->content;

        try {
            Database::begin();
            $save = $this->todoListRepository->save($todoList);

            Database::commit();
            $response = new TodoListResponse();
            $response->todoList = $save;
            return $response;
        }catch (\Exception $exception){
            Database::rollback();
            throw $exception;
        }
    }

    public function update(TodoListRequest $request): TodoListResponse
    {
        $this->validationUpdateTodoListRequest($request);
        try {
            $byID = $this->todoListRepository->findByID($request->id);
            Database::begin();
            $byID->title = $request->title;
            $byID->content = $request->content;
            $byID->updatedAt = $request->updatedAt;

            $update = $this->todoListRepository->update($byID);
            Database::commit();

            $response = new TodoListResponse();
            $response->todoList = $update;
            return $response;
        }catch (\Exception $exception){
            Database::rollback();
            throw $exception;
        }
    }

    public function findByID(int $id): ?TodoListResponse
    {
        try {
            $byID = $this->todoListRepository->findByID($id);
            if ($byID == null){
                throw new ValidationException("Todolist is not found");
            }

            $response = new TodoListResponse();
            $response->todoList = $byID;
            return $response;
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function findByUserID(int $id): array
    {
        try {
            $all = $this->todoListRepository->findAll($id);
            return $all;
        }catch (\Exception $exception){
            throw $exception;
        }
    }


    public function deleteByID(int $id): int
    {
        try {
            $rowAffected = $this->todoListRepository->deleteByID($id);
            if ($rowAffected == 0){
                throw new ValidationException("Error delete this todolist");
            }
            return $rowAffected;

        }catch (\Exception $exception){
            throw $exception;
        }
    }

    private function validationCreateTodoListRequest(TodoListRequest $request):void{

        if (($request->userID==null || trim($request->userID)=="")||
            ($request->title==null || trim($request->title)=="")||
            ($request->content==null || trim($request->content)=="")){
            throw new ValidationException("Your input is blank, please fill that!");
        }
    }

    private function validationUpdateTodoListRequest(TodoListRequest $request):void{

        if (($request->id==null || trim($request->id)=="")||
//            ($request->userID==null || trim($request->userID)=="")||
            ($request->title==null || trim($request->title)=="")||
            ($request->content==null || trim($request->content)=="")){
            throw new ValidationException("Your input is blank, please fill that!");
        }
    }
}