<?php
// query builder

$query = [];

function read(string $table, string $fields = '*')
{
    global $query;

    $query['read'] = true;
    $query['execute'] = [];

    $query['sql'] = "select {$fields} from {$table}";
}

function where()
{
    global $query;

    $args = func_get_args();
    $numArgs = func_num_args();

    if (!isset($query['read'])) {
        throw new Exception('Antes de chamar o where chame o read');
    }

    if ($numArgs < 2 || $numArgs > 3) {
        throw new Exception('O where precisa de 2 ou 3 parâmetros');
    }

    if ($numArgs === 2) {
        $field = $args[0];
        $operator = '=';
        $value = $args[1];
    }

    if ($numArgs === 3) {
        $field = $args[0];
        $operator =  $args[1];
        $value = $args[2];
    }

    $query['where'] = true;
    $query['execute'] = array_merge($query['execute'], [$field => $value]);
    $query['sql'] = "{$query['sql']} where {$field} {$operator} :{$field}";
}


// function where(string $field, string $operator, string|int $value)
// {
//     global $query;

//     if (!isset($query['read'])) {
//         throw new Exception('Antes de chamar o where chame o read');
//     }

//     if (func_num_args() !== 3) {
//         throw new Exception('O where precisa de exatamente 3 parâmetros');
//     }

//     $query['where'] = true;
//     $query['execute'] = array_merge($query['execute'], [$field => $value]);
//     $query['sql'] = "{$query['sql']} where {$field} {$operator} :{$field}";
// }


function orWhere()
{
    global $query;

    $args = func_get_args();
    $numArgs = func_num_args();


    if (!isset($query['read'])) {
        throw new Exception('Antes de chamar o where chame o read');
    }

    if (!isset($query['where'])) {
        throw new Exception('Antes de chamar o orWhere chame o where');
    }

    if ($numArgs < 2 || $numArgs > 4) {
        throw new Exception('O where precisa de 2 até 4 parâmetros');
    }

    $data = match ($numArgs) {
        2 => whereTwoParameters($args),
        3 => whereThreeParameters($args),
        4 => whereFourParameters($args),
    };

    [$field, $operator, $value, $typeWhere] = $data;

    // dd([$field => $value]);

    $query['where'] = true;
    $query['execute'] = array_merge($query['execute'], [$field => $value]);
    $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
}

function whereTwoParameters(array $args):array
{
    $field = $args[0];
    $operator = '=';
    $value = $args[1];
    $typeWhere = 'or';

    return [$field,$operator,$value, $typeWhere];
}
function whereThreeParameters(array $args):array
{
    $operators = ['=','<','>','!==','<=','>='];
    $field = $args[0];
    $operator = in_array($args[1], $operators) ? $args[1] : '=';
    $value = in_array($args[1], $operators) ? $args[2] : $args[1];
    $typeWhere = $args[2] === 'and' ? 'and' : 'or';

    return [$field,$operator,$value, $typeWhere];
}
function whereFourParameters(array $args):array
{
    $field = $args[0];
    $operator = $args[1];
    $value = $args[1];
    $typeWhere = $args[3];

    return [$field,$operator,$value, $typeWhere];
}


// function orWhere(string $field, string $operator, string|int $value, string $typeWhere ='or')
// {
//     global $query;

//     if (!isset($query['read'])) {
//         throw new Exception('Antes de chamar o where chame o read');
//     }

//     if (!isset($query['where'])) {
//         throw new Exception('Antes de chamar o orWhere chame o where');
//     }

//     if (func_num_args() < 3 or func_num_args() > 4) {
//         throw new Exception('O where precisa 3 ou 4 parâmetros');
//     }

//     $query['where'] = true;
//     $query['execute'] = array_merge($query['execute'], [$field => $value]);
//     $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
// }


function limit(string|int $limit)
{
    global $query;

    if (!isset($query['read'])) {
        throw new Exception('Antes de chamar o limit chame o read');
    }

    $query['limit'] = true;
    $query['sql'] = "{$query['sql']} limit {$limit}";
}

function order(string $by, string $descOrAsc = 'ASC')
{
    global $query;

    if (isset($query['paginate'])) {
        throw new Exception('O order nao pode vir depois da paginaçao');
    }

    if (isset($query['limit'])) {
        throw new Exception('O order nao pode vir depois do limit');
    }

    $query['sql'] = "{$query['sql']} order by {$by} {$descOrAsc}";
}

function paginate()
{
    global $query;
}

function execute()
{
    global $query;

    $connect = connect();

    dd($query);
    $prepare = $connect->prepare($query['sql']);
    $prepare->execute($query['execute'] ?? []);

    return $prepare->fetchAll();
}


// query completa
function all($table, $fields = '*')
{
    try {
        $connect = connect();

        $query = $connect->query("select {$fields} from {$table}");
        return $query->fetchAll();
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}

function findBy($table, $field, $value, $fields = '*')
{
    try {
        $connect = connect();
        $prepare = $connect->prepare("select {$fields} from {$table} where {$field} = :{$field}");
        $prepare->execute([
            $field => $value
        ]);

        return $prepare->fetch();
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}
