<?php

namespace Aqibmoh\PHP\MVC\Repository\Session;

use Aqibmoh\PHP\MVC\Domain\Session;

interface SessionRepository
{
    public function save(Session $session):Session;

    public function findByID(string $id):?Session;

    public function deleteByID(string $id):void;

    public function deleteAll():void;

}