<?php

namespace app\controllers;

class Users
{
    public function index(): void
    {
        $users = all('users', 'id,firstName,lastName');

        echo json_encode($users);
    }
}
