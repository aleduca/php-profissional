<?php

function order(string $by, string $order = 'asc')
{
    global $query;

    if (isset($query['limit'])) {
        throw new Exception("O order nao pode vir depois do limit");
    }


    if (isset($query['paginate'])) {
        throw new Exception("O order nao pode vir depois da paginação");
    }

    $query['sql'] = "{$query['sql']} order by {$by} {$order}";
}
