<?php

session_start();

require "functions.php";
include 'includes/_config.php';
include 'includes/_database.php';

getDateSession();
// var_dump($_REQUEST);
generateToken();
postTask($dbCrud);


if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Supprimer') {
    supp($dbCrud);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Suspendre') {
    suspend($dbCrud);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Modifier') {
    gochangeTask($dbCrud);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === '↑') {
    changeTaskPriority($dbCrud, 1, $_REQUEST['id']);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === '↓') {
    changeTaskPriority($dbCrud, -1, $_REQUEST['id']);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'finish') {
    finishTask($dbCrud);
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="content-header" aria-label="header">
            <h1 class="header_ttl">
                <a class="link-dark link-offset-2 link-underline link-underline-opacity-0" href="index.php">My To Do List</a>
            </h1>
        </div>
    </header>
    <main class="content-main">
        <div class="msg"></div>
        <?php


        if (isset($_SESSION['error'])) {
            echo '<p class="notif-error">' . $errors[$_SESSION['error']] . '</p>';
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['msg'])) {
            echo '<p class="notif-success">' . $messages[$_SESSION['msg']] . '</p>';
            unset($_SESSION['msg']);
        }
        ?>
        <div class="content-lst">
            <ul class="p-2 list-group">
                <a href="#" class="my-2 list-group-item list-group-item-success list-group-item-action">teste 1</a>
                <a href="#" class="my-2 list-group-item list-group-item-action list-group-item-danger">teste 2 </a>
                <a href="#" class="my-2 list-group-item list-group-item-action list-group-item-warning">teste 3</a>
                <?php getTask($dbCrud) ?>
            </ul>
        </div>

        <ul id="errorsList" class="errors"></ul>
        <ul id="messagesList" class="messages"></ul>

        <div class="content_add-task">

            <form action="" method="post">

                <div class="mb-3">
                    <label for="InputNewTask" class="form-label">Nouvelle tâche </label>
                    <input type="text" name="name" class="form-control" id="InputNewTask" aria-describedby="taskHelp">
                </div>

                <div class="mb-3">
                    <label for="InputDate" class="form-label">Tâche à effectuer avant le :</label>
                    <input type="text" placeholder="jj/mm/aaaa" name="date" class="form-control" id="InputDate" aria-describedby="dateHelp">
                </div>

                <div class="form-check my-2">
                    <input class="form-check-input" name="checked" type="checkbox" value="urgent" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Urgent
                    </label>
                </div>

                <button type="submit" value="Submit" class="btn btn-success">Ajouter</button>
                <input id='token' type="hidden" name="token" value='<?= $_SESSION['token'] ?>'>


                <input class="btn btn-primary" type="submit" name="action" value='Modifier'>


                <button class="btn btn-danger js-delete-btn" type="button" name="action" value='Supprimer' data-delete="delete-task">Supprimer</button>

                <button class="btn btn-info js-delete-btn" type="button" name="action" value='Terminer' data-finish="finish-task">Terminer</button>

                <input class="btn btn-secondary" type="submit" name="action" value='Suspendre'>

                <input class="btn btn-dark" type="submit" name="action" value='↑'>

                <input class="btn btn-dark" type="submit" name="action" value='↓'>

            </form>
        </div>

    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="js/script.js"></script>

    <template id="templateError">
        <li data-error-message="" class="errors__itm">Ici vient le message d'erreur</li>
    </template>

    <template id="templateMessage">
        <li data-message="" class="messages__itm">Ici vient le message</li>
    </template>

</body>

</html>