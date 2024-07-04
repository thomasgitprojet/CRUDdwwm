<?php
session_start();

require "functions.php";
include 'includes/_database.php';
include 'includes/_config.php';

if (!isset($_REQUEST['action'])) {
    redirectTo('index.php');
}

preventCSRF();

if ($_REQUEST['action'] === 'Supprimer' && isset($_REQUEST['id']) && isset($_REQUEST['action']) ) {
    // supp($dbCrud);
    $query = $objet->prepare ("DELETE FROM `task` WHERE Id_task = :id");

        $queryValues = [
            'id' => $_REQUEST['id']
        ];

        $queryIsOk = $query->execute($queryValues);

        if ($queryIsOk) {
            $url ='index.php?msg=insert_ok';

            redirectTo($url);

            exit;
        } else {

            $url ='index.php?error=insert_ko';
            redirectTo($url);

            exit;
        }     
}

else if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Suspendre') {
    suspend($dbCrud);
}

else if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Modifier') {
    gochangeTask($dbCrud);
}

redirectTo('index.php');