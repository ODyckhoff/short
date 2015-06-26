<?php
   // dbh - database handler. responsible for administering database connections.

    function getDB() {
        $dsn = 'mysql:dbname=short;host=127.0.0.1';
        $db = new PDO($dsn, 'user', 'pass');
        return $db;
    }
