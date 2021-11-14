<?php

namespace app\controllers;

class UserImage
{
    public function store()
    {
        upload(640, 480, 'assets/img');
    }
}
