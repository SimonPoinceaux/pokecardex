<?php
// VARIABLES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$lesSeriesInter = [];
$lesSeriesJap = [];

// TRAITEMENT - SERIES INTER /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défini la requête
$req = "SELECT * FROM serie WHERE loca = 'inter'";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les séries
foreach($res as $row){
    $serie = new Serie ($row['id'], $row['libelle'], GetVersionById($row['version'],$bdd), $row['dateSortie'], $row['nbCartes'], $row['nbSecretes'], $row['loca']);
    array_push($lesSeriesInter, $serie);
}

// TRAITEMENT - SERIES JAP /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défini la requête
$req = "SELECT * FROM serie WHERE loca = 'jap'";

// Lance la requête
$res = $bdd->query($req);

// Récupère toutes les séries
foreach($res as $row){
    $serie = new Serie ($row['id'], $row['libelle'], GetVersionById($row['version'],$bdd), $row['dateSortie'], $row['nbCartes'], $row['nbSecretes'], $row['loca']);
    array_push($lesSeriesJap, $serie);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!-- Présentation des séries --------------------------------------------------------------------------------------------------------------------------------------------> 
<div class="container-xxl">
    <div class="row d-flex align-items-stretch">

        <!-- PREMIERE COLONNE : INTERNATIONALES -->
        <div class="col-12 col-lg-6">
            <div class="shadow col-12 content-element-grey p-3" alt="colonneSerie">

                <!-- TITRE --------------------------------------------------------------------------------------------------------------------------------------------->
                <h1 class="text-center fw-bold mb-3">Séries Internationales</h1>

                <!-- SERIES -------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row gy-3">

                    <!-- EXEMPLE DE SERIE ------------------------------------------------------------------------------------------------------------------------------>
                    <?php foreach($lesSeriesInter as $serie): ?>
                        <div class="col-12 col-sm-6">
                            <a class="d-block no-decoration-link text-reset" href="?serieId=<?php echo $serie->id ?>">
                                <div class="serie-container shadow-sm d-flex align-items-center">
                                    <div class="flex-shrink-0 ms-4">
                                    <img style="width: 38px; height: 38px;" class="img-fluid symbole" src="images/logoSeries/<?php echo $serie->id ?>.png" title="" alt="<?php echo $serie->lib ?>">
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-center p-3">
                                    <img class="img-fluid serie-logo" src="images/series/<?php echo $serie->id ?>.png" alt="<?php echo $serie->lib ?>">
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>
        </div>

        <!-- PREMIERE COLONNE : JAPONAISES -->
        <div class="col-12 col-lg-6">
            <div class="shadow col-12 content-element-grey p-3" alt="colonneSerie">

                <!-- TITRE --------------------------------------------------------------------------------------------------------------------------------------------->
                <h1 class="text-center fw-bold mb-3">Séries Japonaises</h1>

                <!-- SERIES -------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row gy-3">

                    <!-- EXEMPLE DE SERIE ------------------------------------------------------------------------------------------------------------------------------>
                    <?php foreach($lesSeriesJap as $serie): ?>
                        <div class="col-12 col-sm-6">
                            <a class="d-block no-decoration-link text-reset" href="?serieId=<?php echo $serie->id ?>">
                                <div class="serie-container shadow-sm d-flex align-items-center">
                                    <div class="flex-shrink-0 ms-4">
                                    <img style="width: 38px; height: 38px;" class="img-fluid symbole" src="images/logoSeries/<?php echo $serie->id ?>.png" title="" alt="<?php echo $serie->lib ?>">
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-center p-3">
                                    <img class="img-fluid serie-logo" src="images/series/<?php echo $serie->id ?>.png" alt="<?php echo $serie->lib ?>">
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>
        </div>

    </div>
</div>