<?php

namespace Aqibmoh\PHP\MVC\Middleware;

use Aqibmoh\PHP\MVC\App\ViewRender;
use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Repository\Session\SessionRepositoryImpl;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use Aqibmoh\PHP\MVC\Service\Session\SessionService;
use Aqibmoh\PHP\MVC\Service\Session\SessionServiceImpl;
use Couchbase\View;

class MustNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionServiceImpl(
            new SessionRepositoryImpl(Database::getConnectionTest()),
            new UserRepositoryImpl(Database::getConnectionTest())
        );
    }

    public function before(): void
    {
        $currentUser = $this->sessionService->currentUser();
        if ($currentUser != null){
            ViewRender::redirect("/users/workspace");
        }
    }
}