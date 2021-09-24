<?php

namespace app\controllers;

class Home
{
    public function index($params): array
    {
        // $users = all('users');

        read('users', 'id,firstName,lastName');
        where('id', 5);
        orWhere('email', '>', 'xandecar@hotmail.com', 'and');
        order('id', 'asc');
        limit(5);


        $users = execute();

        dd($users);

        // return [
        //     'view' => 'home',
        //     'data' => ['title' => 'Home', 'users' => $users]
        // ];
    }
}
