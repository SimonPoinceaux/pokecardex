<?php
// GLOBALS /////////////////////////////////////////////////////////////////////////////////////////////////////////////
global $bdd;
global $currentPage;
global $errors;

$currentPage = "series";
$errors = [];
$logged = false;

// DÉBUTE LA SESSION ///////////////////////////////////////////////////////////////////////////////////////////////////
session_start();

//var_dump($_POST);

// ALL INCLUDES ////////////////////////////////////////////////////////////////////////////////////////////////////////
// CLASS

// SCRIPTS
include "scripts/functions.php";
include "scripts/sql.php";

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
        $logged = true;
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

        <!-- MES STYLES / CSS ---------------------------------------------------------------------------------------------------------------------------------------------------->
        <link href = "styles/common.css" rel="stylesheet">
        <link href = "styles/navbar.css" rel="stylesheet">
        <link href = "styles/login.css" rel="stylesheet">

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
                    <?php endif ?>

                </ul>
            </div>

        </nav>

        <!-- GROS LOGO ---------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="container logo">
            <img src="images/logo.png" class="logo" alt="Pokécardex Logo" title=""> 
        </div>

        <!-- AFFICHAGE DE LA PAGE ICI -------------------------------------------------------------------------------------------------------------------------------------------> 
        <?php var_dump($_POST); ?>

        <?php 

            // Si il n'est pas logged et qu'on est toujours sur la page de connexion, alors on affiche la connexion
            if ($currentPage == "connexion" && !$logged) {
                include_once("front/connexion.php");
            }
            elseif ($currentPage == "connexion" && $logged) {
                $currentPage = "series";
            }
            elseif ($currentPage != "connexion") {
                include_once("front/".$currentPage.".php");
            }
        
        ?>+

    </body>

</html>