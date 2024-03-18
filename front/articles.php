<?php
// NOS VARAIBLES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$articles = [];

// TRAITEMENT - RECUPERER LES ARTICLES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défini la requête
$req = "SELECT * FROM article";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les séries
foreach($res as $row){
    $article = new Article ($row['id'], $row['titre'], $row['description'], $row['contenu'], $row['imageId']);
    array_push($articles,$article);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!-- LES ARTICLES ----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<main class="container">

<?php foreach ($articles as $article): ?>

        <!-- EXEMPLE D'ARTICLE -------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="row p-4 p-md-5 mb-4 rounded text-body-emphasis article">

            <!-- PARTIE DE GAUCHE ----------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="col-lg-6 px-0">
                <h1 class="display-4 fst-italic"><?php echo $article->titre ?></h1>
                <p class="lead my-3"><?php echo $article->desc ?></p>
                <p class="lead mb-0"><a href="?articleId=<?php echo $article->id ?>" class="text-body-emphasis fw-bold">Continuer de lire...</a></p>
            </div>

            <!-- PARTIE DE DROITE ----------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="col-lg-6 px-0">
                <img src="images/articles/<?php echo $article->imgId ?>" class="mx-auto d-block img-thumbnail rounded mx-auto d-block img-article" title=""> 
            </div>

        </div>

<?php endforeach ?>

</main>