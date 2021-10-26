<?php

function create(string $table, array $data)
{
    try {
        if (!arrayIsAssociative($data)) {
            throw new Exception("O array tem que ser associativo");
        }

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
