<?php

use Doctrine\Inflector\InflectorFactory;

// query builder

$query = [];

function read(string $table, string $fields = '*')
{
    global $query;

    $query = [];

    $query['read'] = true;
    $query['table'] = $table;
    $query['execute'] = [];

    $query['sql'] = "select {$fields} from {$table}";
}

function limit(string|int $limit)
{
    global $query;

    $query['limit'] = true;

    if (isset($query['paginate'])) {
        throw new Exception("O limite nao pode ser chamado com a paginação");
    }

    $query['sql'] = "{$query['sql']} limit {$limit}";
}

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

function paginate(string|int $perPage = 10)
{
    global $query;

    if (isset($query['limit'])) {
        throw new Exception("A paginação nao pode ser chamada com o limite");
    }

    $rowCount = execute(rowCount:true);

    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

    $page = $page ?? 1;

    $query['currentPage'] = (int)$page;
    // 41 / 5
    $query['pageCount'] = (int)ceil($rowCount / $perPage);

    $offset = ($page - 1) * $perPage;

    $query['paginate'] = true;

    $query['sql'] = "{$query['sql']} limit {$perPage} offset {$offset}";

    // dd($query);
}

function render()
{
    global $query;

    $pageCount = $query['pageCount'];
    $currentPage = $query['currentPage'];

    $links = '<ul class="pagination">';

    if ($currentPage > 1) {
        $previous = $currentPage - 1;
        $linkPage = http_build_query(array_merge($_GET, ['page' => $previous]));
        $first = http_build_query(array_merge($_GET, ['page' => 1]));
        $links.= "<li class='page-item'><a href='?{$first}' class='page-link'>Primeira</a></li>";
        $links.= "<li class='page-item'><a href='?{$linkPage}' class='page-link'>Anterior</a></li>";
    }

    $class = '';
    for ($i=1; $i<=$pageCount ; $i++) {
        $page = "?page={$i}";
        $class = $currentPage === $i ? 'active' : '';
        $linkPage = http_build_query(array_merge($_GET, ['page' => $i]));
        $links.= "<li class='page-item {$class}'><a href='?{$linkPage}' class='page-link'>{$i}</a></li>";
    }

    if ($currentPage < $pageCount) {
        $next = $currentPage + 1;
        $linkPage = http_build_query(array_merge($_GET, ['page' => $next]));
        $last = http_build_query(array_merge($_GET, ['page' => $pageCount]));
        $links.= "<li class='page-item'><a href='?{$linkPage}' class='page-link'>Próxima</a></li>";
        $links.= "<li class='page-item'><a href='?{$last}' class='page-link'>Última</a></li>";
    }


    $links .= '</ul>';

    return $links;
}


function where()
{
    global $query;

    if (isset($query['where'])) {
        throw new Exception("Verifique quantos wheres esta sendo chamado na criação da sua query");
    }

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
        4 => $args,
    };

    [$field, $operator, $value, $typeWhere] = $data;

    // dd([$field => $value]);

    $query['where'] = true;
    $query['execute'] = array_merge($query['execute'], [$field => $value]);
    $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
}

function whereTwoParameters(array $args): array
{
    $field = $args[0];
    $operator = '=';
    $value = $args[1];
    $typeWhere = 'or';

    return [$field,$operator,$value, $typeWhere];
}
function whereThreeParameters(array $args): array
{
    $operators = ['=','<','>','!==','<=','>='];
    $field = $args[0];
    $operator = in_array($args[1], $operators) ? $args[1] : '=';
    $value = in_array($args[1], $operators) ? $args[2] : $args[1];
    $typeWhere = $args[2] === 'and' ? 'and' : 'or';

    return [$field,$operator,$value, $typeWhere];
}

function whereIn(string $field, array $data)
{
    global $query;

    if (isset($query['where'])) {
        throw new Exception("Não poder ter chamado a função where com a função where in");
    }

    $query['where'] = true;
    $query['sql'] = "{$query['sql']} where {$field} in (".'\''.implode('\',\'', $data).'\''.')';
}

function fieldFK(string $table, string $field)
{
    $inflector = InflectorFactory::create()->build();
    $tableToSingular = $inflector->singularize($table);

    return $tableToSingular.ucfirst($field);
}


function tableJoin(string $table, string $fieldFK, string $typeJoin = 'inner')
{
    global $query;

    if (isset($query['where'])) {
        throw new Exception("Nao posso colocar o where antes do join");
    }

    $fkToJoin = fieldFK($query['table'], $fieldFK);

    $query['sql'] = "{$query['sql']} {$typeJoin} join {$table} on {$table}.{$fkToJoin} = {$query['table']}.{$fieldFK}";
}

function tableJoinWithFK(string $table, string $fieldFK, string $typeJoin = 'inner')
{
    global $query;

    if (isset($query['where'])) {
        throw new Exception("Nao posso colocar o where antes do join");
    }

    $fkToJoin = fieldFK($table, $fieldFK);

    $query['sql'] = "{$query['sql']} {$typeJoin} join {$table} on {$table}.{$fieldFK} = {$query['table']}.{$fkToJoin}";
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

function execute(bool $isFetchAll = true, bool $rowCount = false)
{
    global $query;

    // dd($query);

    try {
        $connect = connect();

        if (!isset($query['sql'])) {
            throw new Exception("Precisa ter o sql para executar a query");
        }

        $prepare = $connect->prepare($query['sql']);
        $prepare->execute($query['execute'] ?? []);

        if ($rowCount) {
            return $prepare->rowCount();
        }

        return $isFetchAll ? $prepare->fetchAll() : $prepare->fetch();
    } catch (Exception $e) {
        // $message = "Erro no arquivo {$e->getFile()} na linha {$e->getLine()} com a mensagem: {$e->getMessage()}";
        // $message.= $query['sql'];
        $error = [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'sql' => $query['sql'],
        ];

        ddd($error);
    }
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
