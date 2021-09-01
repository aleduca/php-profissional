<?php

namespace app\controllers;

class Home
{
    public function index($params): array
    {
        $users = all('users');

        return [
            'view' => 'home.php',
            'data' => ['title' => 'Home', 'users' => $users]
        ];
    }
}
