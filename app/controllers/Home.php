<?php

namespace app\controllers;

class Home
{
    public function index($params): array
    {
        // $users = all('users');

        read('users', 'id,firstName,lastName');
        $users = execute();

        // select * from users order by id desc limit 10 offset 0

        dd($users);

        return [
            'view' => 'home',
            'data' => ['title' => 'Home', 'users' => $users]
        ];
    }
}
