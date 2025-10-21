<?php

namespace App\Core;

use App\Core\Session;
use App\Controllers\FormController;

class Router
{
    private Session $session;

    public function __construct(?Session $session = null)
    {
        $this->session = $session ?? new Session();
    }

    public function run(): void
    {
        $this->session->start();

        $action = $_GET['action'] ?? 'input';
        $controller = new FormController();

        switch ($action) {
            case 'confirm':
                $controller->confirm();
                break;
            case 'send':
                $controller->send();
                break;
            default:
                $controller->input();
        }
    }
}
