<?php

namespace App\Framework\Database;

class Crud
{
    public static function all($table)
    {
        $sql = "SELECT * FROM {$table}";
        $query =  Connection::$DBH->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }

    public function allWhere($table, $key, $value)
    {
        $query = "SELECT * FROM {$table} WHERE {$key}=:value";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":value", $value);
        $stmt->execute();        
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

    public function allJoinWhere($table, $join, $key, $value)
    {
        //"SELECT * FROM {$table} INNER JOIN {$join} ON user.user_id = guid.user_id"
        $query = "SELECT * FROM {$table} WHERE {$key}=:value";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":value", $value);
        $stmt->execute();        
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

 //SELECT * FROM user INNER JOIN guid ON user.user_id = guid.user_id 
    public function count($table)
    {
        $query = "SELECT * FROM {$table}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $result;
    }

    public static function find($table, $key, $value)
    {
        $query = "SELECT * FROM {$table} WHERE {$key}=:value";
        $stmt = Connection::$DBH->prepare($query);
        $stmt->bindValue(":value", $value);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }

    public function insert($table, array $data)
    {
        $data = $this->prepareDataInsert($data);
        $query = "INSERT INTO {$table} ({$data[0]}) VALUES ({$data[1]})";
        $stmt = $this->pdo->prepare($query);
        for ($i = 0; $i < count($data[2]); $i++) {
            $stmt->bindValue("{$data[2][$i]}", $data[3][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function update($table, array $data, $key, $value)
    {
        $data = $this->prepareDataUpdate($data);
        $query = "UPDATE {$table} SET {$data[0]}  WHERE {$key}=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $value);
        for ($i = 0; $i < count($data[1]); $i++) {
            $stmt->bindValue("{$data[1][$i]}", $data[2][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function delete($table, $id)
    {
        $query = "DELETE FROM {$table} WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    private function prepareDataUpdate(array $data)
    {
        $strKeysBinds = "";
        $binds = [];
        $values = [];

        foreach ($data as $key => $value) {
            $strKeysBinds = "{$strKeysBinds},{$key}=:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        $strKeysBinds = substr($strKeysBinds, 1);
        return [$strKeysBinds, $binds, $values];
    }

    private function prepareDataInsert(array $data)
    {
        $strKeys = "";
        $strBinds = "";
        $binds = [];
        $values = [];

        foreach ($data as $key => $value) {
            $strKeys = "{$strKeys},{$key}";
            $strBinds = "{$strBinds},:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        $strKeys = substr($strKeys, 1);
        $strBinds = substr($strBinds, 1);
        return [$strKeys, $strBinds, $binds, $values];
    }
}
