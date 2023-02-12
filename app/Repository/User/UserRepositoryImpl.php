<?php

namespace Aqibmoh\PHP\MVC\Repository\User;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\User;

class UserRepositoryImpl implements UserRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function save(User $user): User
    {
        $prepare = $this->conn->prepare("insert into users (name, username, password) values (?,?,?)");
        $prepare->execute([$user->name, $user->username, $user->password]);

        $user->id = $this->conn->lastInsertId();
        return $user;
    }

    public function findByID(int $id): ?User
    {
        $prepare = $this->conn->prepare("select * from users where id=?");
        $prepare->execute([$id]);

        try {
            if ($row = $prepare->fetch()) {
                $user = new User();
                $user->id = $row["id"];
                $user->name = $row["name"];
                $user->username = $row["username"];
                $user->password = $row["password"];

                return $user;
            }else{
                return null;
            }
        }finally
        {
            $prepare->closeCursor();
        }
    }

    public function findByUsername(string $username): ?User
    {
        $prepare = $this->conn->prepare("select * from users where username=?");
        $prepare->execute([$username]);

        try {
            if ($row = $prepare->fetch()) {
                $user = new User();
                $user->id = $row["id"];
                $user->name = $row["name"];
                $user->username = $row["username"];
                $user->password = $row["password"];

                return $user;
            }else{
                return null;
            }
        }finally
        {
            $prepare->closeCursor();
        }
    }

    public function deleteByID(int $id): void
    {
        $statement = $this->conn->prepare("delete from users where id=?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->conn->exec("delete from users");
    }


}