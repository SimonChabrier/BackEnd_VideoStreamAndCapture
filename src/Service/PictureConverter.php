<?php

namespace App\Service;

class PictureConverter
{

    //todo il faut que je récupère le fichier base 64 en bdd 
    //todo il faut que je le convertisse
    //todo il faut que je déplace le résulatt de la convertion dans un dossier
    //todo il faut que je persiste le nom du fichier en BDD (dans le bon user)
    //todo il faut que je retourne en GET un groupe avec tout sauf le fichier BASE64
    //todo il faut que je crée ensuite le bon lien côté js


    public function serviceBase64ToJpg($img) //: string
    {
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = "./assets/upload/pictures/" . uniqid() . '.jpeg'; //je déplace le fichier
        $success = file_put_contents($file, $data); 

       
    }
    
}

