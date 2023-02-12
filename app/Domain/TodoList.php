<?php

namespace Aqibmoh\PHP\MVC\Domain;

class TodoList
{
    public int $id;
    public int $userID;
    public string $title;
    public string $content;
    public ?string $createdAt;
    public ?string $updatedAt;
}