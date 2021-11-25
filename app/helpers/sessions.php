<?php

function user()
{
    if (isset($_SESSION[LOGGED])) {
        return $_SESSION[LOGGED];
    }
}


function logged(): bool
{
    return isset($_SESSION[LOGGED]);
}
