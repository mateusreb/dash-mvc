<?php
namespace App\Framework\Database;

use PDO;
use PDOException;

trait DB
{
    private static $DBH;
    
    public static function all($table)
    {
        $sql = "SELECT * FROM {$table}";
        $query =  self::$DBH->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }

    public static function allWhere($table, $key, $value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$key}=:value";
        $query = self::$DBH->prepare($sql);
        $query->bindValue(":value", $value);
        $query->execute();        
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }

    public static function query($sql)
    {
        return self::$DBH->prepare($sql);
    }

    public static function find($table, $key, $value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$key}=:value";
        $query = self::$DBH->prepare($sql);
        $query->bindValue(":value", $value);
        $query->execute();
        $result = $query->fetch();
        $query->closeCursor();
        return $result;
    }

    public static function insert($table, array $data)
    {
        $data = self::prepareDataInsert($data);
        $query = "INSERT INTO {$table} ({$data[0]}) VALUES ({$data[1]})";
        $stmt = self::$DBH->prepare($query);
        for ($i = 0; $i < count($data[2]); $i++) {
            $stmt->bindValue("{$data[2][$i]}", $data[3][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public static function delete($table, $key, $value)
    {
        $query = "DELETE FROM {$table} WHERE {$key}=:value";
        $stmt = self::$DBH->prepare($query);
        $stmt->bindValue(":value", $value);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public static function update($table, array $data, $key, $value)
    {
        $data = self::prepareDataUpdate($data);
        $query = "UPDATE {$table} SET {$data[0]}  WHERE {$key}=:id";
        $stmt = self::$DBH->prepare($query);
        $stmt->bindValue(":id", $value);
        for ($i = 0; $i < count($data[1]); $i++) {
            $stmt->bindValue("{$data[1][$i]}", $data[2][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public static function count($table, $key, $value)
    {
        $query = "SELECT * FROM {$table} WHERE {$key}=:id";
        $stmt = self::$DBH->prepare($query);
        $stmt->bindValue(":id", $value);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        return $result;
    }

    private static function prepareDataUpdate(array $data)
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

    private static function prepareDataInsert(array $data)
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

    public static function openConnection()
    {
        $config = include_once __DIR__ . "/../../../config/database.php";
        try 
        {  
            $pdo = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}", $config['user'], $config['pass']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '{$config['charset']}' COLLATE '{$config['collation']}'");
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$DBH = $pdo;
        } 
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        }
    }
}