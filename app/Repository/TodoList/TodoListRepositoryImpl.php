<?php

namespace Aqibmoh\PHP\MVC\Repository\TodoList;

use Aqibmoh\PHP\MVC\Domain\TodoList;

class TodoListRepositoryImpl implements TodoListRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(TodoList $todoList):TodoList{
        $sql = "insert into todolist (user_id,title,content) values (?,?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $todoList->userID,
            $todoList->title,
            $todoList->content,
        ]);
        $todoList->id = $this->pdo->lastInsertId();
        return $this->findByID($todoList->id);
    }

    public function findByID(int $id): ?TodoList
    {
        $sql = "select * from todolist where id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);

        if ($row = $statement->fetch()){
            $todo = new TodoList();
            $todo->id = $row["id"];
            $todo->userID = $row["user_id"];
            $todo->title = $row["title"];
            $todo->content = $row["content"];
            $todo->createdAt = $row["created_at"];
            $todo->updatedAt = $row["updated_at"];

            return $todo;
        }else{
            return null;
        }
    }

    public function findAll(int $userID): array
    {
        $sql = "select * from todolist where user_id=? order by id desc";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$userID]);

        $all = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $all;
    }


    public function update(TodoList $todoList): TodoList
    {
        $sql = "update todolist set title=?, content=?, updated_at=? where id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$todoList->title, $todoList->content, $todoList->updatedAt, $todoList->id]);

        return $todoList;
    }

    public function deleteByID(int $id): int
    {
        $sql = "delete from todolist where id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);

        return $statement->rowCount();
    }

    public function deleteAll(): int
    {
        $sql = "delete from todolist";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->rowCount();
    }


}