<?php

function validate(array $validations)
{
    $result = [];
    $param = '';
    foreach ($validations as $field => $validate) {
        $result[$field] = (!str_contains($validate, '|')) ?
            singleValidation($validate, $field, $param) :
            multipleValidations($validate, $field, $param);
    }


    if (in_array(false, $result)) {
        return false;
    }

    return $result;
}

function singleValidation($validate, $field, $param)
{
    if (str_contains($validate, ':')) {
        [$validate, $param] = explode(':', $validate);
    }
    return $validate($field, $param);
}

function multipleValidations($validate, $field, $param)
{
    $explodePipeValidate = explode('|', $validate);
    $result = [];
    foreach ($explodePipeValidate as $validate) {
        if (str_contains($validate, ':')) {
            [$validate, $param] = explode(':', $validate);
        }

        if (isset($result[$field]) and $result[$field] === false) {
            continue;
        }

        $result[$field] = $validate($field, $param);
    }
    return $result[$field];
}
