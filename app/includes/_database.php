<?php

try {

    $dbCrud = new PDO(
        'mysql:host=db;dbname=crud;charset=utf8',
        'bébert',
        'dwwm2024'
    );

    $dbCrud->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {

    die('Unable to connect to the database.
    ' . $e->getMessage());
}
return $dbCrud;