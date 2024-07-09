<?php
session_start();

include 'includes/_config.php';
include 'functions.php';
include 'includes/_database.php';

$inputData = json_decode(file_get_contents('php://input'), true);
preventCSRFAPI($inputData);


if (isset($inputData['id']) && is_numeric($inputData['id']) && $_SERVER['REQUEST_METHOD'] === 'DELETE' && $inputData['action'] === 'Supprimer') {
    // supp($dbCrud);
    

    $query = $dbCrud->prepare("DELETE FROM `task` WHERE Id_task = :id");

    $queryValues = [
        'id' => intval($inputData['id'])
    ];

    $queryIsOk = $query->execute($queryValues);

    if (!$queryIsOk) triggerError('delete_ko');

    echo json_encode([
        'id' => intval($inputData['id']),
        'isOk' => $queryIsOk,
        'msgOk' => $messages['delete_ok']
    ]);

} else if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Terminer') {

    $query = $dbCrud->prepare ("UPDATE `task` SET `status`='4' WHERE Id_task = :id");

    $queryValues = [
        'id' => intval($_REQUEST['id'])
    ];

    $queryIsOk = $query->execute($queryValues);

    if (!$queryIsOk) triggerError('finish_ko');

    echo json_encode([
        'id' => intval($_REQUEST['id']),
        'isOk' => $queryIsOk,
        'msgOk' => $messages['finish_ok']
    ]);

};
