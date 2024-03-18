<?php
function hashmdp($mdp){
    return hash("sha256",$mdp);
}

function debug($bool){
    if ($bool)
    {
        ini_set('display_errors', 'On');
    }
    else
    {
        ini_set('display_errors', 'Off');
    }
}