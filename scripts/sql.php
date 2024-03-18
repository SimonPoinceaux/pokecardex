<?php
// phpinfo();
//On établit la connexion
try {
    // Essaye de créer la connexion
    $login = "root";
    $mdp = "";
    $bd = "pokecard";
    $serveur = "127.0.0.1:3306";

    $bdd = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
}
catch(\Exception $e) {
    var_dump($e->getMessage());
}
?>