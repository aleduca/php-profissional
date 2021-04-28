<?php


function create($table, $data)
{
    try {
        // insert into users(firstName,lastName,email,password) values(:firstName,:lastName,:email,:password);
        $connect = connect();

        $sql = "insert into {$table}(";
        $sql.= implode(',', array_keys($data)).") values(";
        $sql.= ':'.implode(',:', array_keys($data)).")";

        $prepare = $connect->prepare($sql);
        return $prepare->execute($data);
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}
