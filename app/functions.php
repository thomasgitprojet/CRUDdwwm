<?php


////////////////////////////////////////////////////////////
// status 1 = en cours 
// status 2 = suspendu 
// satutus 3 = en cours de modification
/////////////////////////////////////////////////////////////

/**
 * Generate a unique token and addto the session 
 *
 * @return void
 */
function generateToken()
{
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    }
}

function redirectTo(string $url): void
{
    // var_dump('REDIRECT ' . $url);
    header('Location: ' . $url);
    exit;
}

/**
 * Verify HTTP referer and token. Redirect with error message.
 *
 * @return void
 */
function preventCSRF(string $redirectUrl = 'index.php'): void
{
    global $globalUrl;

    if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], $globalUrl)) {
        addError('referer');
        redirectTo($redirectUrl);
    }

    if (!isset($_SESSION['token']) || !isset($_REQUEST['token']) || $_SESSION['token'] !== $_REQUEST['token']) {
        addError('csrf');
        redirectTo($redirectUrl);
    }
}

/**
 * Add a new error message to display on next page. 
 *
 * @param string $errorMsg - Error message to display
 * @return void
 */
function addError(string $errorMsg): void
{
    if (!isset($_SESSION['errorsList'])) {
        $_SESSION['errorsList'] = [];
    }
    $_SESSION['errorsList'][] = $errorMsg;
}


/**
 * Add a new message to display on next page. 
 *
 * @param string $message - Message to display
 * @return void
 */
function addMessage(string $message): void
{
    $_SESSION['msg'] = $message;
}

/**
 * Undocumented function
 *
 * @param [type] $callObjet
 * @return void
 */
function getTask($callObjet)
{

    $query = $callObjet->prepare("SELECT id_task, name, status, date_task, priority_level 
    FROM task
    ORDER BY priority_level DESC;");
    $query->execute();

    // $result = $query->fetchAll();

    while ($task = $query->fetch()) {
        // var_dump($task["priority_level"]);
        if ($task["status"] === 1) {
            echo '<a href="?id=' . $task["id_task"] . '" class="my-2 list-group-item list-group-item-action list-group-item-warning">' . $task['name'] . '</a>';
        } 
        // if ($task["priority_level"] === 2 && $task["status"] === 1) {
        //     echo '<a href="?id=' . $task["id_task"] . '" class="my-2 list-group-item list-group-item-action list-group-item-danger">' . $task['name'] . '</a>';
        // }
    }
}

/**
 * Undocumented function
 *
 * @param [type] $objet
 * @return void
 */
function postTask($objet)
{
    if (!empty($_POST)) {
        if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost:8080')) {

            $_SESSION['error'] = 'referer';
            header('Location: index.php');
            // var_dump('referer');
            exit;
        }
        if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']) {

            $_SESSION['error'] = 'csrf';
            header('Location: index.php');
            //  var_dump('csrf');
            exit;
        }

        $errorsList = [];

        if (!isset($_POST['name']) || strlen($_POST['name']) === 0) {
            $errorsList[] = 'Saisissez un nom de tâche';
        }

        if (strlen($_POST['name']) > 50) {
            $errorsList[] = 'Saisissez un nom pour une tâche de 50 caractères au maximum';
        }
        // var_dump($errorsList, $_SESSION);
        if (empty($errorsList)) {

            $query = $objet->prepare("INSERT INTO `task` (`name`, `status`, `date_task`, `priority_level`) 
                VALUES (:name, :status, :date_task, :priority_level)");

            $queryValues = [
                'name' => htmlspecialchars($_POST['name']),
                'status' => 1,
                'date_task' => '2024-06-24',
                'priority_level' => 0
                // !isset($_POST['checked']) ? 1 : 2
            ];

            $queryIsOk = $query->execute($queryValues);

            if ($queryIsOk) {

                header('Location: index.php?msg=insert_ok');

                exit;
            } else {

                header('Location: index.php?error=insert_ko');

                exit;
            }
        }
    }
}

/**
 * Undocumented function
 *
 * @param [type] $objet
 * @return void
 */
function upDateTask($objet)
{
    if (!empty($_POST)) {
        if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost:8080')) {

            $_SESSION['error'] = 'referer';
            header('Location: index.php');
            // var_dump('referer');
            exit;
        }
        if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']) {

            $_SESSION['error'] = 'csrf';
            header('Location: index.php');
            //  var_dump('csrf');
            exit;
        }

        $errorsList = [];

        if (!isset($_POST['name']) || strlen($_POST['name']) === 0) {
            $errorsList[] = 'Saisissez un nom de tâche';
        }

        if (strlen($_POST['name']) > 50) {
            $errorsList[] = 'Saisissez un nom pour une tâche de 50 caractères au maximum';
        }
        // var_dump($errorsList, $_SESSION);
        if (empty($errorsList)) {
            
            $query = $objet->prepare("UPDATE task SET name = :name, status = :status WHERE Id_task=:id_task");

            $queryValues = [
                'name' => htmlspecialchars($_POST['name']),
                'id_task' => intval($_POST['id']),
                'status' => 1
            ];

            $queryIsOk = $query->execute($queryValues);

            if ($queryIsOk) {

                header('Location: index.php?msg=insert_ok');

                exit;
            } else {

                header('Location: index.php?error=insert_ko');

                exit;
            }
        }
    }
}

/**
 * Undocumented function
 *
 * @param [type] $objet
 * @return void
 */
function supp ($objet) {

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

/**
 * Undocumented function
 *
 * @param [type] $objet
 * @return void
 */
function suspend ($objet) {

    $query = $objet->prepare ("UPDATE `task` SET `status`='2' WHERE Id_task = :id");

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

function gochangeTask ($objet) {

    $query = $objet->prepare ("UPDATE `task` SET `status`='3' WHERE Id_task = :id");

    $queryValues = [
        'id' => $_REQUEST['id']
    ];

    $queryIsOk = $query->execute($queryValues);

        if ($queryIsOk) {
            $url ='page-modif.php';

            redirectTo($url);

            exit;
        } else {

            $url ='index.php?error=update_ko';
            redirectTo($url);

            exit;
        }   
}

function changeTaskPriority (PDO $db, int $changingValue, int $id): void
{
    try {
        $db->beginTransaction();

        $query = $db->prepare("SELECT Id_task FROM task WHERE priority_level = (
            SELECT priority_level + :changingValue FROM task WHERE Id_task = :id);");

            $query->execute([
                'id'=>$id,
                'changingValue' => $changingValue
            ]);

            $idToMove = intval($query->fetchColumn());
            var_dump($idToMove);
            if ($idToMove !== false) {
                $queryUpdate = $db->prepare("UPDATE task SET priority_level = priority_level + :changingValue WHERE Id_task = :id;");
                $queryUpdate->execute([
                    'id'=>$idToMove,
                    'changingValue' => $changingValue * -1
                ]);
            }

            $queryUpdate = $db->prepare("UPDATE task SET priority_level = priority_level + :changingValue WHERE Id_task = :id;");
            $isUpdateOk = $queryUpdate->execute([
                'id'=>$id,
                'changingValue' => $changingValue
            ]);

            $db->commit();

            if ($isUpdateOk) {
                addMessage('update_ok');
            }else {
                addError('update_ko');
            }

    }catch (Exception $e) {
        $db->rollBack('update_ko');
    }
}

//////////////////////////////page-modif//////////////////////

/**
 * Undocumented function
 *
 * @param [type] $objet
 * @return void
 */
function getTaskValueToChange($objet) {

    $query = $objet->prepare("SELECT id_task, name, status, date_task, priority_level 
    FROM task
    ORDER BY priority_level DESC;");
    $query->execute();

    while ($task = $query->fetch()) {
        // var_dump($task["priority_level"]);
        if ($task["priority_level"] === 1 && $task["status"] === 3) {
            echo $task['name'];
        } 
        if ($task["priority_level"] === 2 && $task["status"] === 3) {
            echo $task['name'];
        }
    }

}

/**
 * Undocumented function
 *
 * @param [type] $objet
 * @return void
 */
function getTaskIdToChange($objet) {

    $query = $objet->prepare("SELECT id_task, name, status, date_task, priority_level 
    FROM task
    ORDER BY priority_level DESC;");
    $query->execute();

    while ($task = $query->fetch()) {
        // var_dump($task["priority_level"]);
        if ($task["priority_level"] === 1 && $task["status"] === 3) {
            echo $task['id_task'];
        } 
        if ($task["priority_level"] === 2 && $task["status"] === 3) {
            echo $task['id_task'];
        }
    }

}

// '<a href="?id=' . $task["id_task"] . '" class="my-2 list-group-item list-group-item-action list-group-item-warning">' . $task['name'] . '</a>'

// '<a href="?id=' . $task["id_task"] . '" class="my-2 list-group-item list-group-item-action list-group-item-danger">' . $task['name'] . '</a>'