<?php

function redirect($to)
{
    return header('Location: '.$to);
}

function setMessageAndRedirect($index, $message, $redirectTo)
{
    setFlash($index, $message);
    return redirect($redirectTo);
}
