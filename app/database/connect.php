<?php

function connect()
{
    return new PDO("mysql:host=localhost;dbname=lumen", "root", "", [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
}
