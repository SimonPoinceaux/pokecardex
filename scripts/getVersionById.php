<?php
function GetVersionById($id,$bdd)
{
    $version = null;
    $req = "SELECT * FROM version WHERE id = '$id'";
    // Lance la requête
    $res = $bdd->query($req);

    foreach($res as $row){
        $version = new Version ($row['id'], $row['libelle']);
    }

    return $version;
}