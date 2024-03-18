<?php 
// VARIABLES /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$errors = [];
$feedbacks = [];

$versions = [];

// TRAITEMENT - RECUP POUR AFFICHAGE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 1 - LES VERSIONS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défini la requête
$req = "SELECT * FROM version";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les versions
foreach($res as $row){
    $version = new Version ($row['id'], $row['libelle']);
    array_push($versions,$version);
}

// TRAITEMENT - AJOUT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// AJOUT SERIE
if (isset($_POST['ajouterSerie'])){
    
     // On définie notre petite erreure
     $erreur = false;

     // On regarde dans le poste s'il y a un champ qui est vide
     foreach($_POST as $key=>$value){
         if ($value == '' && $key != "ajouterSerie"){
            $erreur = true;
         }
     }

     // Si on a une erreur, alors on balance le feedback d'erreur, sinon on ajoute l'article !
    if ($erreur){
        array_push($errors,"Aucun champ ne doit être vide !");
    }
    else{

        // ON DEFINI NOS VARIABLES ICI !!!
        $nom = $_POST['nom'];
        $version = $_POST['version'];
        $dateSortie = $_POST['dateSortie'];
        $nbCartes = $_POST['nbCartes'];
        $nbSecretes = $_POST['nbSecretes'];
        $provenance = $_POST['provenance'];

        // Défini la requête
        $req = "INSERT INTO serie(libelle,version,dateSortie,nbCartes,nbSecretes,loca) VALUES ('$nom','$version','$dateSortie','$nbCartes','$nbSecretes','$provenance');";

        // Lance la requête
        $res = $bdd->query($req);
                
        // Ajoute le feedback
        array_push($feedbacks,"La série a été ajoutée avec succès !");

    }

}

// AJOUT ARTICLE
else if (isset($_POST['ajouterArticle'])){
    
    // On définie notre petite erreure
    $erreur = false;

    // On regarde dans le poste s'il y a un champ qui est vide
    foreach($_POST as $key=>$value){
        if ($value == '' && $key != "ajouterArticle"){
           $erreur = true;
        }
    }

    // Si on a une erreur, alors on balance le feedback d'erreur, sinon on ajoute l'article !
    if ($erreur){
        array_push($errors,"Aucun champ ne doit être vide !");
    }
    else{

        // ON DEFINI NOS VARIABLES ICI !!!
        $nom = $_POST['nom'];
        $desc = $_POST['desc'];
        $nomImage = $_POST['nomImage'];
        $contenu = $_POST['contenu'];
        $contenu = addslashes($contenu);

        // Défini la requête
        $req = "INSERT INTO article(titre,description,imageId,contenu) VALUES ('$nom','$desc','$nomImage','$contenu');";

        // Lance la requête
        $res = $bdd->query($req);
        
        // Ajoute le feedback
        array_push($feedbacks,"L'article a été ajouté avec succès !");

    }

}

// AJOUT VERSION
else if (isset($_POST['ajouterVersion'])){

    // On récupère le nom
    $nom = $_POST['nom'];

    // On vérifie que le nom est pas vide
    if ($nom != ''){

        // Défini la requête
        $req = "INSERT INTO version (libelle) VALUES ('$nom');";

        // Lance la requête
        $res = $bdd->query($req);

        // Ajoute le feedback
        array_push($feedbacks,"La version a été ajoutée avec succès !");

    }
    // S'il est vide on rajoute l'erreur
    else{
        array_push($errors,"Le champ du nom ne peut pas être vide !");
    }


}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!-- AFFICHAGE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<main class="container">

<!-- AFFICHAGE DES ERREURS & FEEDBACKS ---------------------------------------------------------------------------------------------------------------------------------------------->
<?php if(count($errors) > 0): ?>

    <?php foreach($errors as $error): ?>

        <div class="alert alert-danger" role="alert">
            <strong>Erreur : </strong> <?php echo $error; ?>
        </div>

    <?php endforeach ?>

<?php elseif (count($feedbacks)>0): ?>

    <?php foreach($feedbacks as $feedback): ?>

        <div class="alert alert-success" role="alert">
            <strong><?php echo $feedback; ?></strong>
        </div>

    <?php endforeach ?>

<?php endif ?>

<!-- PREMIERE PARTIE : AJOUTER DES SERIES ------------------------------------------------------------------------------------------------------------------------------------------->
<div class="flex-column">

    <!-- TITRE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <h3 class="pb-4 mb-4 fst-italic border-bottom">
        Créer une série
    </h3>

    <!-- CONTENUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <article class="blog-post">
    <form method="POST">

        <!-- NOM DE LA SERIE --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" placeholder="Faille Paradoxe">
        </div>

        <!-- VERSION ------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">

            <!-- Nom ------------------------------------------------------->
            <label for="version">Version</label>

            <!-- Options ---------------------------------------------------->
            <select class="form-control" name="version">

                <?php foreach($versions as $version): ?>
                    <option value="<?php echo $version->id; ?>" > <?php echo $version->lib; ?> </option>
                <?php endforeach ?>

            </select>

        </div>

        <!-- DATE DE SORTIE --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="dateSortie">Date de sortie</label>
            <input type="text" class="form-control" name="dateSortie" placeholder="2024-01-26">
        </div>

        <!-- NOMBRE DE CARTES --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="nbCartes">Nombre de cartes</label>
            <input type="text" class="form-control" name="nbCartes" placeholder="266">
        </div>

        <!-- NOMBRE DE SECRETES --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="nbSecretes">Nombre de cartes secrètes</label>
            <input type="text" class="form-control" name="nbSecretes" placeholder="84">
        </div>

        <!-- NATIONALITE ------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">

            <!-- Nom ------------------------------------------------------->
            <label for="provenance">Nationalité / Provenance</label>

            <!-- Options ---------------------------------------------------->
            <select class="form-control" name="provenance">
            <option value="inter">Française</option>
            <option value="jap">Japonaise</option>
            </select>

        </div>

        <!-- BOUTON DE REDEEM -------------------------------------------------------------------------------------------------------------------------------------------->
        <button type="submit" name="ajouterSerie" class="btn btn-dark">Ajouter</button>

    </form>
    </article>

</div>
<br>

<!-- DEUXIEME PARTIE : AJOUTER DES ARTICLES ----------------------------------------------------------------------------------------------------------------------------------------->
<div class="flex-column">

    <!-- TITRE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <h3 class="pb-4 mb-4 fst-italic border-bottom">
        Créer un article
    </h3>

    <!-- CONTENUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <article class="blog-post">
    <form method="POST">

        <!-- NOM DE LA SERIE --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" placeholder="Nouvelle collection de sortie !!">
        </div>

        <!-- DESCRIPTION --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="desc">Description</label>
            <input type="text" class="form-control" name="desc" placeholder="Une nouvelle collection importée du japon vient de sortir !">
        </div>

        <!-- NOM DE L'IMAGE --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="nomImage">Nom de l'image</label>
            <input type="text" class="form-control" name="nomImage" placeholder="5.png">
        </div>

        <!-- DESCRIPTION ------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="form-group">
            <label for="contenu">Contenu</label>
            <textarea class="form-control" name="contenu" rows="5"></textarea>
        </div>

        <!-- BOUTON DE REDEEM -------------------------------------------------------------------------------------------------------------------------------------------->
        <button type="submit" name="ajouterArticle" class="btn btn-dark">Ajouter</button>

    </form>
    </article>

</div>
<br>

<!-- TROISIEME PARTIE : AJOUTER DES VERSIONS ----------------------------------------------------------------------------------------------------------------------------------------->
<div class="flex-column">

    <!-- TITRE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <h3 class="pb-4 mb-4 fst-italic border-bottom">
        Créer une version
    </h3>

    <!-- CONTENUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <article class="blog-post">

        <form method="POST">

            <!-- NOM DE LA SERIE --------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" placeholder="Ecarlate & Violet">
            </div>

            <!-- BOUTON DE REDEEM -------------------------------------------------------------------------------------------------------------------------------------------->
            <button type="submit" name="ajouterVersion" class="btn btn-dark">Ajouter</button>

        </form>

    </article>
 
</div>
<br><br><br><br>
</main>