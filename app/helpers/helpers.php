<?php

function arrayIsAssociative(array $arr)
{
    return array_keys($arr) !== range(0, count($arr) - 1);
}
