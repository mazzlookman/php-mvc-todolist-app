<?php

namespace Aqibmoh\PHP\MVC\Repository\TodoList;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\TodoList;
use Aqibmoh\PHP\MVC\Domain\User;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use PHPUnit\Framework\TestCase;

class TodoListRepositoryImplTest extends TestCase
{
    private TodoListRepository $todoListRepository;
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $this->userRepository = new UserRepositoryImpl(Database::getConnectionTest());
        $this->todoListRepository = new TodoListRepositoryImpl(Database::getConnectionTest());
    }

    private function saveUser():User{
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = password_hash("123",PASSWORD_BCRYPT);
        return $this->userRepository->save($user);
    }

    private function saveTodo(User $user):TodoList{
        $todo = new TodoList();
        $todo->userID = $user->id;
        $todo->title = "Title";
        $todo->content = "Content";
//        $todo->createdAt = date("Y-m-d H:i:s");
//        $todo->updatedAt = date("Y-m-d H:i:s");
        return $this->todoListRepository->save($todo);
    }

    public function testSave()
    {
        $user = $this->saveUser();
        $todoList = $this->saveTodo($user);
        var_dump($todoList);

        self::assertEquals($user->id,$todoList->userID);
    }

    public function testFindByID()
    {
        $byID = $this->todoListRepository->findByID(12);
        var_dump($byID);
        self::assertNotNull($byID);
    }

    public function testUpdate()
    {
        $user = $this->saveUser();
        $todoList = $this->saveTodo($user);
        $todoList->content = "Ini content baru";

        $update = $this->todoListRepository->update($todoList);
        self::assertEquals($todoList->content, $update->content);
    }

    public function testDeleteByID()
    {
//        $user = $this->saveUser();
//        $todoList = $this->saveTodo($user);

        $deleteByID = $this->todoListRepository->deleteByID(200);
        self::assertEquals(1, $deleteByID);
    }

    public function testDeleteAll()
    {
        $user = $this->saveUser();
        $this->saveTodo($user);

        $deleteAll = $this->todoListRepository->deleteAll();
        var_dump($deleteAll);
        self::assertNotNull($deleteAll);
    }

    public function testFindAll()
    {
        $all = $this->todoListRepository->findAll(85);
        var_dump($all[0]["id"]);
        self::assertNotNull($all);
    }


}
