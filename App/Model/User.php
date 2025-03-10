<?php

namespace App\Model;


use Core\Model;
use PDO;

class User extends Model
{

    function get($id)
    {
        // wenn static ist und verbindung zu databse
        //  $db = static::getDb();

        // wenn nicht static ist und verbindung zu databse
        // $db = $this->getDb();

    }


    public function getAll()
    {
        $db = $this->getDb();
        $stmt = $db->query("SELECT * FROM `users`");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }


    public function getById($id)
    {
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM `users` WHERE id = :userID');
        $stmt->bindParam(":userID", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function add(array $data)
    {
        $stmt = $this->getDb()->prepare("INSERT INTO `users` (name , age) VALUES (:name , :age)");
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":age", $data['age']);
        return $stmt->execute();
    }

    public function update(array $data)
    {
        $stmt = $this->getDb()->prepare("UPDATE `users` SET name = :name , SET age =:age WHERE id = :userId");
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":age", $data['age']);
        $stmt->bindParam(":userId", $data['id']);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->getDb()->prepare("DELETE FROM `users` WHERE id = :userId ");
        $stmt->bindParam(":userId", $id);
        return $stmt->execute();
    }


}
