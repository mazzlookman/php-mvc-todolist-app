<?php

namespace Aqibmoh\PHP\MVC\Repository\User;

use Aqibmoh\PHP\MVC\Domain\User;

interface UserRepository
{
    public function save(User $user):User;

    public function findByID(int $id):?User;

    public function findByUsername(string $username):?User;

    public function deleteByID(int $id):void;

    public function deleteAll():void;
}