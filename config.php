<?php

if (!defined('HOST')) {
    define('HOST', 'localhost');
}

if (!defined('DBNAME')) {
    define('DBNAME', 'eindopdrachtraket');
}

if (!defined('USER')) { 
    define('USER', 'root');
}

if (!defined('PASSWORD')) {
    define('PASSWORD', '');
}

try {
    global $pdo;
    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>