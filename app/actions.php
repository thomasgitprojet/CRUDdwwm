<?php
session_start();


include 'includes/_functions.php';

if (!isset($_REQUEST['action'])) {
    redirectTo('index.php');
}

// if ($_REQUEST['action'] === 'increase' && isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {

//     $query = $dbCo->prepare("UPDATE product SET price = price * 1.1 WHERE ref_product = :id;");
//     $isUpdateOk = $query->execute(['id' => intval($_REQUEST['id'])]);

//     if ($isUpdateOk) {
//         $_SESSION['msg'] = 'update_ok';
//     } else {
//         $_SESSION['error'] = 'update_ko';
//     }
// }