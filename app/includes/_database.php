<?php

require __DIR__ . '/../vendor/autoload.php';
// $_ENV

$dotenv = Dotenv\Dotenv :: createImmutable (__DIR__ . '/../');
 $dotenv -> load ();

try {

    $dbCrud = new PDO(
        'mysql:host=' . $_ENV["DB_HOST"].';dbname=' . $_ENV["DB_NAME"]. ';charset=utf8',
        $_ENV['DB_USER'],
        $_ENV['DB_PWD']
    );

    $dbCrud->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {

    die('Unable to connect to the database.
    ' . $e->getMessage());
}
return $dbCrud;