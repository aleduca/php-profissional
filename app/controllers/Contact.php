<?php

namespace app\controllers;

use stdClass;

class Contact
{
    public function index()
    {
        return [
            'view' => 'contact',
            'data' => ['title' => 'Contact',],
        ];
    }

    public function store()
    {
        // $email = new stdClass();
        // $email->fromName = 'Alexandre';
        // $email->fromEmail = 'xandecar@hotmail.com';
        // $email->toName = 'Joao';
        // $email->toEmail = 'joao@email.com.br';
        // $email->subject = 'teste de mensagem';
        // $email->message = 'mensagem simples';
        // $email->template = 'contact';

        $validated = validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ], persistInputs:true, checkCsrf:true);

        if (!$validated) {
            return redirect('/contact');
        }

        $sent = send([
            'fromName' => $validated['name'],
            'fromEmail' => $validated['email'],
            'toName' => $_ENV['TONAME'],
            'toEmail' => $_ENV['TOEMAIL'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'template' => 'contact'
        ]);

        if ($sent) {
            return setMessageAndRedirect('contact_success', 'Enviado com sucesso', '/contact');
        }
        return setMessageAndRedirect('contact_error', 'Ocorreu um erro ao enviar o email, tente novamente em alguns segundos', '/contact');
    }
}
