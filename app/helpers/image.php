<?php

function getExtension(string $name)
{
    return pathinfo($name, PATHINFO_EXTENSION);
}

function isFileToUpload($fieldName)
{
    if (!isset($_FILES[$fieldName]) || !isset($_FILES[$fieldName]['name']) || $_FILES[$fieldName]['name'] === '') {
        throw new Exception("O campo {$fieldName} não existe ou não foi escolhida uma imagem");
    }
}

function isImage($extension)
{
    if (!in_array($extension, ['jpeg','jpg','gif','png'])) {
        throw new Exception("O arquivo não é aceito");
    }
}
