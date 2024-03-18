<?php
// NOS VARIABLES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$idArticle;
$currentArticle;

// TRAITEMENT - ARTICLE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Vérif pour obtenir l'id
if (isset($_GET["articleId"])){
    $idArticle = $_GET["articleId"];
};

// Nos variables
$idArticle;
$currentArticle;

// Petite vérification, s'il y a bien un article, alors on peut récupérer son id pour les procédures suivantes
if (isset($_GET["idArticle"])){
    $idArticle = $_GET["idArticle"];
};

// Défini la requête
$req = "SELECT * FROM article WHERE id = '$idArticle'";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les séries
foreach($res as $row){
    $article = new Article ($row['id'], $row['titre'], $row['description'], $row['contenu'], $row['imageId']);
    $currentArticle = $article;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!-- AFFICHAGE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<main class="container">

<!-- ARTICLE EN LUI-MÊME ------------------------------------------------------------------------------------------------------------------------------------------------------------>
<div class="flex-column">

    <!-- TITRE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <h3 class="pb-4 mb-4 fst-italic border-bottom">
        <?php echo $currentArticle->titre ?>
    </h3>

    <!-- CONTENUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <article class="blog-post">
        <p><?php echo $currentArticle->contenu ?></p>
    </article>

</div>

</main>