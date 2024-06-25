<?php 
require "functions.php";

$objet = callBd();
postTask($objet);
// var_dump($_SERVER);
var_dump($_POST);

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
        <div class="content-lst">
            <ul class="p-2 list-group">
                <!-- <button type="button" class="my-2 list-group-item list-group-item-success list-group-item-action">teste 1</button>
                <button type="button" class="my-2 list-group-item list-group-item-action list-group-item-danger">teste 2</button>
                <button type="button" class="my-2 list-group-item list-group-item-action list-group-item-warning">teste 3</button> -->
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
                
                <button type="submit" value="Submit" class="btn btn-success">Valider</button>
                
              </form>
        </div>
        <div class="content_supp-eddit">
            <a href="page-modif.php" class="btn btn-primary " role="button">
                Modifier
            </a>
            <button class="btn btn-danger disabled">
                Suprimer
            </button>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>