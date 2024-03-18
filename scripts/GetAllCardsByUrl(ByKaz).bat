@echo off
setlocal enabledelayedexpansion

rem URL de base pour les images
set "base_url=https://www.pokecardex.com/assets/images/sets/PAF/"

rem Répertoire de destination pour enregistrer les images
set "destination_folder=C:\wamp64\www\PokecardexV3\images\cartes\13"

rem Créer le répertoire s'il n'existe pas déjà
mkdir "%destination_folder%" 2>nul

rem Téléchargement des images
for /l %%i in (1,1,245) do (
    set "url=!base_url!%%i.jpg"
    curl -o "%destination_folder%\%%i.jpg" -L "!url!"
    if not errorlevel 1 (
        echo Téléchargement de l'image %%i terminé.
    ) else (
        echo Échec du téléchargement de l'image %%i.
    )
)

endlocal