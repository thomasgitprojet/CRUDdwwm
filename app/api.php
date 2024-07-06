<?php
session_start();

include 'includes/_config.php';
include 'functions.php';
include 'includes/_database.php';


if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Supprimer') {
    // supp($dbCrud);

    $query = $objet->prepare ("DELETE FROM `task` WHERE Id_task = :id");
        
        $queryValues = [
            'id' => intval($_REQUEST['id'])
        ];
        
        $queryIsOk = $query->execute($queryValues);

        if ($queryIsOk) {
            $queryValues['id'] = intval($_REQUEST['id']);
        } 

        echo json_encode($queryValues);

}