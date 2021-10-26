<?php

function connect()
{
    return new PDO(
        "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']}",
        $_ENV['DATABASE_USER'],
        $_ENV['DATABASE_PASSWORD'],
        [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]
    );
}
