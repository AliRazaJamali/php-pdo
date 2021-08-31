<?php

class DB
{
    private $conn;
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');
            self::$instance->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

    public function all($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function single($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            return $stmt->fetch();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function create($query)
    {
        try {
            $this->conn->exec($query);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function statement($query)
    {
        try {
            return $this->conn->exec($query);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}