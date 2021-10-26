<?php

function validate(array $validations, bool $persistInputs = false, bool $checkCsrf = false)
{
    if ($checkCsrf) {
        checkCsrf();
    }

    $result = [];
    $param = '';
    foreach ($validations as $field => $validate) {
        $result[$field] = (!str_contains($validate, '|')) ?
            singleValidation($validate, $field, $param) :
            multipleValidations($validate, $field, $param);
    }

    if ($persistInputs) {
        setOld();
    }

    if (in_array(false, $result, true)) {
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

        $result[$field] = $validate($field, $param);

        if ($result[$field] === false || $result[$field] === null) {
            break;
        }
    }
    return $result[$field];
}
