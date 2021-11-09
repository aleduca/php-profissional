<?php

namespace app\controllers;

class UserImage
{
    public function store()
    {
        $extension = getExtension($_FILES['file']['name']);
        isImage($extension);
    }
}
