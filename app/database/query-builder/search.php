<?php

function search(array $search)
{
    global $query;

    if (isset($query['where'])) {
        throw new Exception("Não pode chamar o where na busca");
    }

    if (!arrayIsAssociative($search)) {
        throw new Exception("Na busca o array tem que ser associativo");
    }

    $sql = "{$query['sql']} where ";

    $execute = [];
    foreach ($search as $field => $searched) {
        $sql.= "{$field} like :{$field} or ";
        $execute[$field] = "%{$searched}%";
    }

    $sql = rtrim($sql, ' or ');

    $query['sql'] = $sql;
    $query['execute'] = $execute;
}
