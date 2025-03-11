<?php

namespace core;

use PDO;
use Core\Config;

abstract class Model
{
    protected $table = null;

    protected function getDb() {
        static $db = null;

        if ($db === null) {
            $dsn = "mysql:host=" . Config::DB_HOST . ";dbname=" .Config::DB_NAME;
            $db = new PDO($dsn , Config::DB_USERNAME,Config::DB_PASSWORD);
        }
        return $db;
    }

    public function getAll()
    {
        $db = $this->getDb();
        $stmt = $db->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }


    public function getById($id)
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM $this->table WHERE id = :userID");
        $stmt->bindParam(":userID", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function add(array $data)
    {
        $stmt = $this->getDb()->prepare("INSERT INTO $this->table (name , age) VALUES (:name , :age)");
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":age", $data['age']);
        return $stmt->execute();
    }

    public function update(array $data)
    {
        $stmt = $this->getDb()->prepare("UPDATE $this->table SET name = :name , SET age =:age WHERE id = :userId");
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":age", $data['age']);
        $stmt->bindParam(":userId", $data['id']);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->getDb()->prepare("DELETE FROM $this->table WHERE id = :userId ");
        $stmt->bindParam(":userId", $id);
        return $stmt->execute();
    }
}

?>
