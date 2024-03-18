<?php
// DÉBUTE LA SESSION ///////////////////////////////////////////////////////////////////////////////////////////////////
session_start();

// GLOBALS /////////////////////////////////////////////////////////////////////////////////////////////////////////////
global $bdd;
global $currentPage;
global $errors;

$currentPage = "aucune";
$errors = [];

$booster = false;

// ALL INCLUDES ////////////////////////////////////////////////////////////////////////////////////////////////////////
// CLASS
include "classes/article.php";
include "classes/serie.php";
include "classes/version.php";

// SCRIPTS
include "scripts/functions.php";
include "scripts/sql.php";
include "scripts/getVersionById.php";

// AFFICHER LES MESSAGES D'ERREURS ///////////////////////////////////////////////////////////////////////////////////////////////////
debug(false);

// Si des informations ont été entrées, alors on continue
if(isset($_POST['identifiant']) && isset($_POST['password'])) {

    // Récupère les identifiants de connexion admins avant tout
    $postLogin = $_POST['identifiant'];
    $postMdp = $_POST['password'];

    $sqlLogin;
    $sqlMdp;

    // Défini la requête
    $req = "SELECT * FROM User WHERE ident = '$postLogin'";

    // Lance la requête
    $res = $bdd->query($req);

    // Récupère déjà le nombre de résultats
    $results = $res->rowCount();

    // S'il y a un résultat, alors on a l'identifiant et on peut poursuivre
    if($results > 0) 
    {

        // Récupère les données
        foreach($res as $row)
        {
            $sqlLogin = $row["ident"];
            $sqlMdp = $row["mdp"];
        }

        // Récupère le mot de passe fourni par l'utilisateur en version hash
        $hMdp = hashmdp($postMdp);
        echo $hMdp;
        echo "<br>";
        echo $sqlMdp;

        // Vérifie que le mot de passe est bien égal à celui dans la BDD
        if ($hMdp != $sqlMdp){
            $errors[] = "Identifiant ou mot de passe incorrect";
        }

    }
    // Sinon, on donne une erreur et on arrête d'essayer de login
    else 
    {
        $errors[] = "Identifiant ou mot de passe incorrect";
    }

    // Si il n'y a aucune erreur, alors on peut se connecter
    if(count($errors) === 0) {
        $_SESSION['logged']=true;
    }

}

// Récupère la current page
if(isset($_GET["page"])){
    $currentPage = $_GET["page"];
}
elseif(isset($_GET["serieId"])){
    $currentPage = "serieDetail";
}
elseif(isset($_GET["articleId"])){
    $currentPage = "articleDetail";
}

// Définition de la variable de logged
$logged = false;
if ($currentPage === "aucune"){
    $_SESSION["logged"] = false;
}
elseif ($_SESSION["logged"] === true)
{
    $logged = true;
}

// Si il n'est pas logged et qu'on est toujours sur la page de connexion, alors on affiche la connexion
if ($currentPage == "connexion" && $logged === false) {
    $currentPage = "connexion";
}
elseif ($logged === true && $currentPage === "connexion") {
    $currentPage = "series";
}
elseif ($currentPage == "aucune"){
    $currentPage = "series";
}
else {
    if(isset($_GET["page"])){
        $currentPage = $_GET["page"];
    }
}

// AFFICHAGE /////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!-- FRONT HTML ------------------------------------------------------------------------------------------------------------------------------------------------------------------>
<!DOCTYPE html>
<html>

    <!-- PARTIE HEADER ----------------------------------------------------------------------------------------------------------------------------------------------------------->
    <head>

        <!-- BOOTSRAP ------------------------------------------------------------------------------------------------------------------------------------------------------------>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
        <link href = "styles/bootstrap.css" rel="stylesheet">
        <link href = "styles/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Chicle|Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

        <!-- MES STYLES / CSS ---------------------------------------------------------------------------------------------------------------------------------------------------->
        <link href = "styles/common.css" rel="stylesheet">
        <link href = "styles/navbar.css" rel="stylesheet">
        <link href = "styles/login.css" rel="stylesheet">
        <link href = "styles/modifier.css" rel="stylesheet">

    </head>

    <!-- TESTS ------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <body>

        <!-- BARRE DE NAVIGATION ------------------------------------------------------------------------------------------------------------------------------------------------->
        <nav class="navbar shadow-lg fixed-top navbar-expand-lg navbar-dark bg-dark">

            <a class="navbar-brand">
                <img src="images/mini_logo.png" class="img-fluid" alt="Pokécardex Logo" title="">
            </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-md-0">

                    <li class="nav-item <?php if ($currentPage == "series") echo 'active'; ?>">
                        <a class="nav-link" href="?page=series">Séries</a>
                    </li>

                    <li class="nav-item <?php if ($currentPage == "articles") echo 'active'; ?>">
                        <a class="nav-link" href="?page=articles">Articles</a>
                    </li>

                    <?php if(!$logged): ?>
                    <li class="nav-item <?php if ($currentPage == "connexion") echo 'active'; ?>">
                        <a class="nav-link" href="?page=connexion">Connexion</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item <?php if ($currentPage == "publier") echo 'active'; ?>">
                        <a class="nav-link" href="?page=publier">Ajouter</a>
                    </li>
                    <li class="nav-item <?php if ($currentPage == "modifier") echo 'active'; ?>">
                        <a class="nav-link" href="?page=modifier">Modifier</a>
                    </li>
                    <?php endif ?>

                </ul>
            </div>

        </nav>

        <!-- GROS LOGO ---------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="container logo">
            <img src="images/logo.png" class="logo" alt="Pokécardex Logo" title=""> 
        </div>

        <!-- AFFICHAGE DE LA PAGE ICI -------------------------------------------------------------------------------------------------------------------------------------------> 
        <?php // include_once("temp/testConnexion.php"); ?>
        <?php include_once("front/".$currentPage.".php"); ?>

    </body>

</html>