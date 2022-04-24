<?php
// déplacement vers et/ou création de repertoire
// https://www.php.net/manual/en/function.file-put-contents.php

namespace App\Service;

class jpegConverterService
{
    /**
     * Convertisseur d'image Base64 vers jpg
     * traite le fichier base64 pour le convertir en jpg et le déplace 
     * dans le repertoire défini.
     * @param string $img
     * @return string
     */
    public function convertPictureService (string $img):string
    {   
        //*marche si post depuis le front
        $directoryPath = 'assets/upload/pictures/';

        //*marche avec ma commande mais PAS si post depuis le front
        //$directoryPath = "public/assets/upload/pictures/";

        $img = str_replace('data:image/jpeg;base64,', '', $img); // 1er traitement du fichier base64
        $img = str_replace(' ', '+', $img);  // 2eme traitement du fichier base64
        $data = base64_decode($img); // on decode vers un format jpg. $data est maintenant le fichier jpg
        $pictureFile = uniqid() . '.jpeg'; // on crée aléatoirement un nom unique xxxxxx.jpg
        $destination =  $directoryPath . $pictureFile; // on lui donne la valeur à écrire dans le rep : assets/upload/pictures/xxxxxx.jpg en concaténant
        file_put_contents($destination, $data); //on déplace dans le rep : $destination le fichier jpg : $data 

        return $pictureFile; //on retourne la valueur sting de $pictureFile pour la persister en Bdd si on utilise le service
    }
}


