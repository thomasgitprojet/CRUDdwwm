<?php


////////////////////////////////////////////////////////////
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
 * Undocumented function
 *
 * @return void
 */
function callBd()
{
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
        if ($task["priority_level"] === 1 && $task["status"] === 1) {
            echo '<a href="?id=' . $task["id_task"] . '" class="my-2 list-group-item list-group-item-action list-group-item-warning">' . $task['name'] . '</a>';
        } 
        if ($task["priority_level"] === 2 && $task["status"] === 1) {
            echo '<a href="?id=' . $task["id_task"] . '" class="my-2 list-group-item list-group-item-action list-group-item-danger">' . $task['name'] . '</a>';
        }
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
                'priority_level' => !isset($_POST['checked']) ? 1 : 2
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

