<?php

/**
 * Undocumented function
 *Get the lst of values of array
 * @param [type] $array
 * @return void
 */
function getLst($array)
{
    foreach ($array as $value) {
        echo "<li>$value</li>";
    }
}

/**
 * Undocumented function
 *
 * @return void
 */
function callBd () {
    try {
    
        $dbCrud = new PDO(
            'mysql:host=db;dbname=crud;charset=utf8',
            'bébert',
            'dwwm2024'
        );
    
        $dbCrud->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
    
        die('Unable to connect to the database.
        '.$e->getMessage());
    }
    return $dbCrud;
}

/**
 * Undocumented function
 *
 * @param [type] $callObjet
 * @return void
 */
function getTask($callObjet) {

    $query = $callObjet->prepare("SELECT name, status, date_task, priority_level 
    FROM task
    ORDER BY priority_level DESC;");
    $query->execute();
    
    // $result = $query->fetchAll();
    
    while ($task = $query->fetch()) {
        // var_dump($task["priority_level"]);
        if ($task["priority_level"] === 1) {
            echo '<button type="button" class="my-2 list-group-item list-group-item-action list-group-item-warning">'.$task['name'].'</button>';
        }else {
            echo '<button type="button" class="my-2 list-group-item list-group-item-action list-group-item-danger">'.$task['name'].'</button>';
        }
    }
}

function postTask($objet) {
    if (!empty($_POST)) {
        if(
            isset($_POST['name'])
            && strlen($_POST['name']) > 0
            && strlen($_POST['name']) <= 50
        ){
            $query = $objet->prepare ("INSERT INTO `task` (`name`, `status`, `date_task`, `priority_level`) 
            VALUES (:name, :status, :date_task, :priority_level)");

            $query->execute ([
                'name' => htmlspecialchars($_POST['name']),
                'status' => 1,
                'date_task' => '2024-06-24',
                'priority_level' => !isset($_POST['checked']) ? 1 : 2
            ]);
        
        }
    }
    
}

// $query = $dbCrud->prepare ("INSERT INTO `task` (`name`, `status`, `date_task`, `priority_level`) 
// VALUES (:name, :status, :date_task, :priority_level)");

// $query->execute ([
//     'name' => 'retrouver mon slip',
//     'status' => 1,
//     'date_task' => '2024-06-24',
//     'priority_level' => 1
// ]);