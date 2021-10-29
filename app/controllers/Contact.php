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


        $sent = send([
            'fromName' => 'Alexandre',
            'fromEmail' => 'xandecar@hotmail.com',
            'toName' => 'Joao',
            'toEmail' => 'joao@email.com.br',
            'subject' => 'Assunto com array',
            'message' => 'mensagem com um array',
            'template' => 'contact'
        ]);

        dd($sent);
    }
}
