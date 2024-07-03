<?php 

require "functions.php";
// var_dump($_GET);
// var_dump($_POST);
session_start();
$objet = callBd();
// var_dump(getTaskToChange($objet));

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
        <div class="content_add-task">
            <form action="" method="post">
                <div class="mb-3">
                  <label for="edditTask" class="form-label">modifier tâche </label>
                  <input type="submits" class="form-control" id="edditTask" aria-describedby="modifierTask" value='<?= getTaskToChange($objet) ?>'>
                </div>
<!-- Je récupère bien la tâche que je cherche à modifier mais je ne sais pas comment la renvoyer une fois modifiée                              -->
                <button type="submit" value="Submit" class="btn btn-success">Ajouter</button>
                <input type="hidden" name="token" value='<?= $_SESSION['token'] ?>'>
              </form>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="index.php" class="btn btn-primary " role="button">
                Retour
            </a>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>