<?php


function getCsrf()
{
    $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(8));

    return "<input name='csrf' type='hidden' value=".$_SESSION["csrf"].">";
}

function checkCsrf()
{
    $csrf = filter_input(INPUT_POST, 'csrf', FILTER_SANITIZE_STRING);

    if (!$csrf) {
        throw new Exception('Token inválido');
    }

    if (!isset($_SESSION['csrf'])) {
        throw new Exception('Token inválido');
    }

    if ($csrf !== $_SESSION['csrf']) {
        throw new Exception('Token inválido');
    }

    unset($_SESSION['csrf']);
}
