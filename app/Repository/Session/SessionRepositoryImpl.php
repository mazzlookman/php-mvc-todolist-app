<?php

namespace Aqibmoh\PHP\MVC\Repository\Session;

use Aqibmoh\PHP\MVC\Domain\Session;

class SessionRepositoryImpl implements SessionRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Session $session): Session
    {
        $sql = "insert into sessions (id, user_id) values (?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$session->id, $session->userId]);

        return $session;
    }

    public function findByID(string $id):?Session
    {
        $sql = "select * from sessions where id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);

        if ($row = $statement->fetch()){
            $session = new Session();
            $session->id = $row["id"];
            $session->userId = $row["user_id"];

            return $session;
        }
        return null;
    }

    public function deleteByID(string $id): void
    {
        $sql = "delete from sessions where id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("delete from sessions");
    }
}