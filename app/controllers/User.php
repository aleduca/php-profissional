<?php

namespace app\controllers;

class User
{
    public function show($params)
    {
        if (!isset($params['user'])) {
            return redirect('/');
        }

        $user = findBy('users', 'id', $params['user']);
        var_dump($user);
        die();
    }


    public function edit()
    {
        if (!logged()) {
            redirect('/');
        }

        read('users', 'users.id,firstName,lastName,email,password,path');
        tableJoin('photos', 'id', 'left');
        where('users.id', user()->id);

        $user = execute(isFetchAll:false);

        return [
            'view'  => 'edit',
            'data' => ['title' => 'Edit','user' => $user]
        ];
    }

    public function create()
    {
        return [
            'view'  => 'create',
            'data' => ['title' => 'Create']
        ];
    }

    public function store()
    {
        $validate = validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'maxlen:5|required',
        ], persistInputs:true, checkCsrf:true);

        if (!$validate) {
            return redirect('/user/create');
        }

        $validate['password'] = password_hash($validate['password'], PASSWORD_DEFAULT);

        $created = create('users', $validate);

        if (!$created) {
            setFlash('message', 'Ocorreu um erro ao cadastrar, tente novamente em alguns segundo');
            return redirect('/user/create');
        }

        return redirect('/');
    }

    public function update($args)
    {
        if (!isset($args['user']) || $args['user'] !== user()->id) {
            return redirect('/');
        }

        $validated = validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|uniqueUpdate:users,id='.$args['user']
        ]);


        if (!$validated) {
            return redirect('/user/edit/profile');
        }

        $updated = update('users', $validated, ['id' => user()->id]);

        if ($updated) {
            setMessageAndRedirect('updated_success', 'Atualizado com sucesso', '/user/edit/profile');
            return;
        }
        setMessageAndRedirect('updated_error', 'Ocorreu um erro ao atualizar', '/user/edit/profile');
    }
}
