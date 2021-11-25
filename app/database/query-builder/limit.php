<?php

function limit(string|int $limit)
{
    global $query;

    $query['limit'] = true;

    if (isset($query['paginate'])) {
        throw new Exception("O limite nao pode ser chamado com a paginação");
    }

    $query['sql'] = "{$query['sql']} limit {$limit}";
}
