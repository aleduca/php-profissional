<?php

namespace app\controllers;

class Login
{
    public function index(): array
    {
        return [
            'view' => 'login',
            'data' => ['title' => 'Login']
        ];
    }

    public function store()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (empty($email) || empty($password)) {
            return setMessageAndRedirect('message', 'Usuário ou senha inválidos', '/login');
        }

        // $user = findBy('users', 'email', $email);

        read('users', 'users.id,firstName,lastName,email,password,path');
        tableJoin('photos', 'id', 'left');
        where('email', $email);

        $user = execute(isFetchAll:false);

        // dd($user);

        if (!$user) {
            return setMessageAndRedirect('message', 'Usuário ou senha inválidos', '/login');
        }

        if (!password_verify($password, $user->password)) {
            return setMessageAndRedirect('message', 'Usuário ou senha inválidos', '/login');
        }

        unset($user->password);

        $_SESSION[LOGGED] = $user;

        return redirect('/');
    }

    public function destroy()
    {
        unset($_SESSION[LOGGED]);

        return redirect('/');
    }
}
