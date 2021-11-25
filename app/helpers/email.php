<?php

use PHPMailer\PHPMailer\PHPMailer;

function config()
{
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = $_ENV['EMAIL_HOST'];
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $_ENV['EMAIL_PORT'];
    $phpmailer->Username = $_ENV['EMAIL_USERNAME'];
    $phpmailer->Password = $_ENV['EMAIL_PASSWORD'];

    return $phpmailer;
}

function send(stdClass|array $emailData)
{
    try {
        if (is_array($emailData)) {
            $emailData = (object) $emailData;
        }

        $body = (isset($emailData->template)) ? template($emailData) : $emailData->message;

        checkPropertiesEmail($emailData);

        $mail = config();
        $mail->setFrom($emailData->fromEmail, $emailData->fromName);
        $mail->addAddress($emailData->toEmail, $emailData->toName);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $emailData->subject;
        $mail->Body    = $body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        return $mail->send();
    } catch (Exception $e) {
        dd($e->getMessage());
    }
}

function checkPropertiesEmail($emailData)
{
    $propertiesRequired = ['toName','toEmail','fromName','fromEmail','subject','message'];
    unset($emailData->template);

    $emailVars = get_object_vars($emailData);

    foreach ($propertiesRequired as $prop) {
        if (!array_key_exists($prop, $emailVars)) {
            throw new Exception("{$prop} é obrigatório para enviar o email");
        }
    }
}


function template($emailData)
{
    $templateFile = ROOT."/app/views/emails/{$emailData->template}.html";

    if (!file_exists($templateFile)) {
        throw new Exception("O template {$emailData->template}.html não existe");
    }

    $template = file_get_contents($templateFile);

    $emailVars = get_object_vars($emailData);

    $arr = array_map(function ($key) {
        return "@{$key}";
    }, array_keys($emailVars));

    // dd($arr);

    // $vars = [];

    // foreach ($emailVars as $key => $value) {
    //     $vars["@{$key}"] = $value;
    // }

    return str_replace($arr, array_values($emailVars), $template);
}
