<?php

namespace app\controllers;

class Password
{
    public function update($args)
    {
        if (!isset($args['user']) || $args['user'] !== user()->id) {
            return redirect('/');
        }

        $validated = validate([
            'email' => 'required|confirmed',
            'email_confirmation' => 'required'
        ], checkCsrf: true);


        if (!$validated) {
            return redirect('/user/edit/profile');
        }

        dd($validated);
        $updated = update('users', [
            'password' => $validated['password']
        ], ['id' => user()->id]);

        if ($updated) {
            $user = user();
            send([
                'fromName' => 'Alexandre',
                'fromEmail' => 'xandecar@hotmail.com',
                'toName' => $user->firstName,
                'toEmail' => $user->email,
                'subject' => 'Senha alterada',
                'message' => 'Senha alterada com sucesso',
                'template' => 'password'
            ]);
            return setMessageAndRedirect('password_success', 'Senha alterada com sucesso', "/user/edit/profile");
        } else {
            return setMessageAndRedirect('password_error', 'Ocorreu um erro ao atualizar a senha ', "/user/edit/profile");
        }

    }

}