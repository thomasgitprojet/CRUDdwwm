<?php 

session_start();

require "functions.php";


generateToken();
$objet = callBd();
postTask($objet);


if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {
    supp($objet);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'suspend') {
    suspend($objet);
}

if (isset($_REQUEST['id']) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'gochange') {
    gochangeTask($objet);
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
    <?php

        $errors = [
            'csrf' => 'Votre session est invalide.',
            'referer' => 'D\'où venez vous ?',
            'insert_ko' => 'Erreur lors de la sauvegarde de la produit.',
            'update_ko' => 'Erreur lors de la modif du produit.'
        ];
        if (isset($_SESSION['error'])) {
            echo '<p class="notif-error">' . $errors[$_SESSION['error']] . '</p>';
            unset($_SESSION['error']);
        }

        $messages = [
            'insert_ok' => 'tâche sauvegardée.',
            'update_ok' => 'tâche modifié.'
        ];
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
                <?php getTask($objet) ?>
            </ul>
        </div>
        <div class="content_add-task">
            <form action="" method="post">

                <div class="mb-3">
                  <label for="InputNewTask" class="form-label">Nouvelle tâche </label>
                  <input type="text" name="name" class="form-control" id="InputNewTask" aria-describedby="taskHelp">
                </div>

                <div class="form-check my-2">
                    <input class="form-check-input" name="checked" type="checkbox" value= "urgent" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Urgent
                    </label>
                </div>
                
                <button type="submit" value="Submit" class="btn btn-success">Ajouter</button>
                <input type="hidden" name="token" value='<?= $_SESSION['token'] ?>'>

              
               
<!-- Je n'arrive pas à faire fonction mes trois buttons, je suis obliger de commenter deux boutons pour en faire fonctionner 1 -->


                    <button type="submit" value="button" class="btn btn-primary">Modifier</button>
                    <input type="hidden" name="action" value='gochange'>
                
                    <button type="submit" value="button" class="btn btn-danger">Supprimer</button>
                    <input type="hidden" name="action" value='delete'>

                    <button type="submit" value="button" class="btn btn-secondary">Suspendre</button>
                    <input type="hidden" name="action" value='suspend'>
                
            </form>
        </div>

    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>