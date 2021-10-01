<?php

function arrayIsAssociative(array $arr)
{
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function isAjax():bool
{
    return isset($_SERVER['HTTP_HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

function ddd($data)
{
    if ($_ENV['PRODUCTION'] === 'true') {
        dd('Something get wrong');
    }
    dd($data);
}
