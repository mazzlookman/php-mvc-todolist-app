<?php

namespace Aqibmoh\PHP\MVC\Model;

class TodoListRequest
{
    public ?int $id;
    public int $userID;
    public string $title;
    public string $content;
    public ?string $updatedAt;
}