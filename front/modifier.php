<?php 
// NOS VARIABLES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tryModif = false;
$trySupp = false;

$needToSupp = false;
$needModif = false;

$modifId = 0;
$serieAModif;

$versions = [];
$series = [];

$errors = [];
$feedbacks = [];

// TRAITEMENT DU POST POUR SAVOIR SI ON VEUT MODIFIER OU NON //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST)){

    // Si on tente de modifier, alors on change les valeurs
    if(isset($_POST['modifier'])){

        // Défini qu'on veut modifier
        $tryModif = true;

        // Récupère l'ID a modifier
        $modifId = $_POST['modifier'];

        // On créer la série en concordance à celle qu'on a choisit
        // Défini la requête
        $req = "SELECT * FROM serie WHERE id = '$modifId'";

        // Lance la requête
        $res = $bdd->query($req);

        // Récupère toutes les versions
        foreach($res as $row){
            $serie = new Serie ($row['id'], $row['libelle'], GetVersionById($row['version'],$bdd), $row['dateSortie'], $row['nbCartes'], $row['nbSecretes'], $row['loca']);
            $serieAModif = $serie;
        }

    }
    // Si on cherche à supprimer, alors on change les valeurs pour afficher la confirmation
    elseif(isset($_POST['supprimer'])){
        $trySupp = true;
        $modifId = $_POST['supprimer'];
    }
    // Si on cherche à LANCER la suppression, alor son change les valeurs pour se faire
    elseif(isset($_POST['lancerSuppression'])){
        $needToSupp = true;
        $modifId = $_POST['lancerSuppression'];
    }
    // Si on cherche à LANCER la modification, alors on change les valeurs adéquates
    elseif(isset($_POST['lancerModif'])){
        $needModif = true;
        $modifId = $_POST['lancerModif'];
    }

}

// ON RECUPËRE TOUTES NOS VERSIONS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défini la requête
$req = "SELECT * FROM version";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les versions
foreach($res as $row){
    $version = new Version ($row['id'], $row['libelle']);
    array_push($versions,$version);
}

// TRAITEMENT DES ACTIONS DE SUPPRESSION ET DE MODIFICATION ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ACTION DE SUPPRESSION
if ($needToSupp){

    // Défini la requête
    $req = "DELETE FROM serie WHERE id = '$modifId'";

    // Lance la requête
    $res = $bdd->query($req);

    // Ajoute les petits feedback qui vont bien
    array_push($feedbacks,"La série a été supprimée avec succès !");

}

// ACTION DE MODIFICATION
if ($needModif){

    // ON DEFINI NOS VARIABLES ICI !!!
    $nom = $_POST['nom'];
    $version = $_POST['version'];
    $dateSortie = $_POST['dateSortie'];
    $nbCartes = $_POST['nbCartes'];
    $nbSecretes = $_POST['nbSecretes'];
    $provenance = $_POST['provenance'];
    
    // Défini la requête
    $req = "UPDATE serie
    SET libelle = '$nom',
        version = '$version',
        dateSortie = '$dateSortie',
        nbCartes = '$nbCartes',
        nbSecretes = '$nbSecretes',
        loca = '$provenance'
    WHERE ID = '$modifId';";
    
    // Lance la requête
    $res = $bdd->query($req);
                    
    // Ajoute le feedback
    array_push($feedbacks,"La série a été modifiée avec succès !");

}
// ON RECUPERE TOUTES NOS SERIES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défini la requête
$req = "SELECT * FROM serie";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les séries
foreach($res as $row){
    $serie = new Serie ($row['id'], $row['libelle'], GetVersionById($row['version'],$bdd), $row['dateSortie'], $row['nbCartes'], $row['nbSecretes'], $row['loca']);
    array_push($series, $serie);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php if(!$tryModif): ?>

    <!-- MAIN PAGE AFFICHAGE DE TOUTES LES SERIES --------------------------------------------------------------------------------------------------------------------------------->
    <main class="container">

        <!-- PETIT POP UP SI ON ESSAYE DE MODIFIER -------------------------------------------------------------------------------------------------------------------------------->
        <?php if($trySupp): ?>

            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-3 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Êtes vous sûr de vouloir supprimer cette série ?</h5>
                        <p class="mb-0">Il n'y aura pas de retour en arrière possible.</p>
                    </div>

                    <form method="POST">
                        <div class="modal-footer flex-nowrap p-0">
                            <button type="submit" name="lancerSuppression" value="<?php echo $modifId ?>" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end">
                                <strong>Supprimer</strong>
                            </button>
                            <button type="submit" name="annuler" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0">Annuler</button>
                        </div>
                    </form> 
                </div>
            </div>

        <?php endif ?>

        <!-- AFFICHAGE DES ERREURS & FEEDBACKS ------------------------------------------------------------------------------------------------------------------------------------>
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

        <!-- AFFICHAGE DES SERIES ------------------------------------------------------------------------------------------------------------------------------------------------>
        <div class="album py-5">
            <div class="container">
                <div class="row">

                    <!--  EXEMPLE D'UNE SERIE ------------------------------------------------------------------------------------------------------------------------------------->
                    <?php foreach($series as $serie): ?>

                        <div class="col-md-4 col-sm-6">
                            <div class="card shadow-sm">

                                <img src="images/series/<?php echo $serie->id ?>.png" height="150">

                                <div class="card-body">
                                    <p class="card-text"><strong><?php echo $serie->lib ?></strong></p>
                                        <div class="d-flex justify-content-between align-items-center">

                                        <form method="POST">
                                            <div class="btn-group">
                                                <button type="submit" name="modifier" value="<?php echo $serie->id ?>" class="btn btn-sm btn-outline-primary">Modifier</button>
                                                <button type="submit" name="supprimer" value="<?php echo $serie->id ?>" class="btn btn-sm btn-outline-primary">Supprimer</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php endforeach ?>

                </div>  
            </div>  
        </div>

    </main>

<?php elseif($tryModif): ?>

    <!-- MAIN PAGE AFFICHAGE MODIFICATION --------------------------------------------------------------------------------------------------------------------------------->
    <main class="container">

        <!-- MODIFICATION DE LA SERIE ------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="flex-column">

            <!-- TITRE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                Modifier la série : <?php echo $serieAModif->lib ?>
            </h3>

            <!-- CONTENUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <article class="blog-post">
            <form method="POST">

                <!-- NOM DE LA SERIE --------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" name="nom" value="<?php echo $serieAModif->lib ?>">
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
                    <input type="text" class="form-control" name="dateSortie" value="<?php echo $serieAModif->dateSortie ?>">
                </div>

                <!-- NOMBRE DE CARTES --------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                    <label for="nbCartes">Nombre de cartes</label>
                    <input type="text" class="form-control" name="nbCartes" value="<?php echo $serieAModif->nbCartes ?>">
                </div>

                <!-- NOMBRE DE SECRETES --------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                    <label for="nbSecretes">Nombre de cartes secrètes</label>
                    <input type="text" class="form-control" name="nbSecretes" value="<?php echo $serieAModif->nbSecretes ?>">
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
                <button type="submit" name="lancerModif" value="<?php echo $serieAModif->id ?>" class="btn btn-dark">Modifier</button>

            </form>
            </article>

        </div>
        <br>

    </main>

<?php endif ?>