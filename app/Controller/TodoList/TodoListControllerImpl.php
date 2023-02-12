<?php

namespace Aqibmoh\PHP\MVC\Controller\TodoList;

use Aqibmoh\PHP\MVC\App\ViewRender;
use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Model\TodoListRequest;
use Aqibmoh\PHP\MVC\Repository\Session\SessionRepositoryImpl;
use Aqibmoh\PHP\MVC\Repository\TodoList\TodoListRepository;
use Aqibmoh\PHP\MVC\Repository\TodoList\TodoListRepositoryImpl;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use Aqibmoh\PHP\MVC\Service\Session\SessionService;
use Aqibmoh\PHP\MVC\Service\Session\SessionServiceImpl;
use Aqibmoh\PHP\MVC\Service\TodoList\TodoListService;
use Aqibmoh\PHP\MVC\Service\TodoList\TodoListServiceImpl;

class TodoListControllerImpl implements TodoListController
{

    private TodoListService $todoListService;
    private SessionService $sessionService;

    public function __construct()
    {
        $this->todoListService = new TodoListServiceImpl(
            new TodoListRepositoryImpl(Database::getConnectionTest())
        );
        $this->sessionService = new SessionServiceImpl(
            new SessionRepositoryImpl(Database::getConnectionTest()),
            new UserRepositoryImpl(Database::getConnectionTest())
        );
    }


    public function postCreate(): void
    {
        $currentUser = $this->sessionService->currentUser();

        $request = new TodoListRequest();
        $request->userID = $currentUser->id;
        $request->title = strip_tags($_POST["titleTodo"]);
        $request->content = strip_tags($_POST["contentTodo"]);

        try {
            $this->todoListService->create($request);
            ViewRender::redirect("/users/workspace");
        }catch (\Exception $exception){
            ViewRender::render("User/work_space.php",[
                "error"=>$exception->getMessage()
            ]);
        }
    }

    public function update(): void
    {

    }

    public function postUpdate(): void
    {
        $request = new TodoListRequest();
        $request->id = $_POST["idTodo"];
        $request->title = strip_tags($_POST["updateTitle"]);
        $request->content = strip_tags($_POST["updateContent"]);
        $request->updatedAt = date("Y-m-d H:i:s");
        try {
            $this->todoListService->update($request);
            ViewRender::redirect("/users/workspace");
        }catch (\Exception $exception){
            ViewRender::render("User/work_space.php",[
                "error"=>$exception->getMessage()
            ]);
        }
    }

    public function postDeleteByID(): void
    {
        $id = $_POST["idTodo"];
//        $message = "Todolist has been successfully deleted";
            try {
                $this->todoListService->deleteByID($id);
                ViewRender::redirect("/users/workspace");
            }catch (\Exception $exception){
                ViewRender::render("User/work_space.php",[
                    "error"=>$exception->getMessage()
                ]);
            }
        }
}