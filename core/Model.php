<?php

namespace core;

use PDO;

abstract class Model
{

    protected function getDb() {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=localhost,dbname=mvc';
            $db = new PDO($dsn , 'root','');
        }
        return $db;
    }
}
