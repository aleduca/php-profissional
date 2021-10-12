<?php

namespace app\controllers;

class Home
{
    public function index($params): array
    {
        $search = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);

        read('posts', 'posts.id,title,slug,content,firstName,email,lastName');

        tableJoinWithFK('users', 'id');

        where('firstName', 'Jazmyne Wiza');

        // where('id', '<', 20);
        // whereIn('firstName', ['Alexandre','Prof. Lulu Ullrich','Loma Champlin']);

        // if ($search) {
        //     search(['firstName' => $search,'lastName' => $search]);
        // }

        // limit(10);


        // select * from users where firstName like %alexandre% or lastName like %alexandre% or age

        $users = execute();

        dd($users);

        // dd($users);

        // select * from users order by id desc limit 10 offset 0

        // dd($users);

        return [
            'view' => 'home',
            'data' => ['title' => 'Home', 'users' => $users]
        ];
    }
}
