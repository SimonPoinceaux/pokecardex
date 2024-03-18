<?php 
// VARIABLES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$serieID;
$currentSerie;
$cartes = [];

// TRAITEMENT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Petite vérification, s'il y a bien une série, alors on peut récupérer son id pour les procédures suivantes
if (isset($_GET["serieId"])){
    $serieID = $_GET["serieId"];
};

// On essaye de récupérer les informations sur la série
// Défini la requête
$req = "SELECT * FROM serie WHERE id = '$serieID'";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les séries
foreach($res as $row){
    $serie = new Serie ($row['id'], $row['libelle'], GetVersionById($row['version'],$bdd), $row['dateSortie'], $row['nbCartes'], $row['nbSecretes'], $row['loca']);
    $currentSerie = $serie;
}

?>
<main class="flex-shrink-0"> 
    <div class="container px-4">
        <div class="row gx-5">
            
            <!-- BANDEREAU EN HAUT ------------------------------------------------------------------------------------------------------------------------------------------>
            <div class="background-primary p-3 serie-details-presentation">
                <div class="row d-flex align-items-center">

                    <!-- PARTIE GAUCHE : LOGO DE LA SERIE ----------------------------------------------------------------------------------------------------------------------->
                    <div class="col-lg-6 col-12">
                        <div class="serie-details-presentation text-center">
                            <img class="img-fluid serie-logo-big" src="images/series/<?php echo $serie->id ?>.png" alt="Faille Paradoxe">							
                        </div>
                    </div>

                    <!-- PARTIE DROITE : BOUTONS ET INFORMATIONS ---------------------------------------------------------------------------------------------------------------->
                    <div class="col-lg-6 col-12">
                        <div class="serie-details-presentation">

                            <!-- TITRE ---------------------------------------------------------------------------------------------------------------------------------------------->
                            <h5 class="d-block text-center mb-3">
                                <?php echo $serie->lib ?>					
                            </h5>

                            <div class="row d-flex align-items-center">

                                <!-- INFORMATIONS DE LA SERIE ---------------------------------------------------------------------------------------------------------------------->
                                <div class="col-lg-6 col-12">

                                    <!-- DATE DE SORTIE ---------------------------------------------------------------------------------------------------------------------------->
                                    <div class="d-flex align-items-center mt-2 d-none d-lg-block justify-content-lg-start">
                                        <?php if($serie->loca == "jap"): ?>
                                            <img src="//www.pokecardex.com/assets/images/japan_flag.png" class="news-flag-mini" alt="Actualités françaises" title="">
                                        <?php else: ?>
                                            <img src="//www.pokecardex.com/assets/images/french_flag.png" class="news-flag-mini" alt="Actualités françaises" title="">
                                        <?php endif ?>
                                        <?php echo $serie->dateSortie ?>	
                                    </div>

                                    <!-- NB CARTES --------------------------------------------------------------------------------------------------------------------------------->
                                    <div class="d-flex align-items-center mt-2 justify-content-center justify-content-lg-start mb-3 mb-lg-0">
                                        <img style="" class="img-fluid news-flag-mini" src="images/logoSeries/<?php echo $serie->id ?>" title="" alt="<?php echo $serie->lib ?>">
                                        <?php echo $serie->nbCartes." cartes (".$serie->nbSecretes." secrètes)";	?>						
                                    </div>
                                </div>

                                <!-- BOUTONS ---------------------------------------------------------------------------------------------------------------------------------------->
                                <div class="col-lg-6 col-12">
                                    <div class="d-grid gap-2">
                                        <a href="" type="button" class="btn btn-sm btn-outline-dark">Checklist</a>
                                        <a href="?idBooster=1" type="button" class="btn btn-sm btn-outline-dark">Boosters</a>							
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTE DES CARTES ------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="row d-flex align-items-center gy-3 mt-1">

                <!-- EXEMPLE DE CARTE --------------------------------------------------------------------------------------------------------------------------------------->
                <?php for ($i = 1; $i <= $serie->nbCartes ; $i++): ?>
                            
                    <div class="serie-details-carte col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 text-center content">
                        <a title="" data-errata="" data-fancybox="galery" data-caption="" class="fancybox" rel="group" href='<?php echo "images/cartes/".$serieID."/".$i.".jpg" ?>'>
                            <img src='<?php echo "images/cartes/".$serieID."/".$i.".jpg" ?>' class="img-fluid br-10 dark-shadow" data-original='<?php echo "images/cartes/".$serieID."/".$i.".jpg" ?>' alt="">
                        </a>											
                    </div>

                <?php endfor; ?>

            </div>

        </div>
    </div>
</main>