<?php
// déplacement vers et/ou création de repertoire
// https://www.php.net/manual/en/function.file-put-contents.php

namespace App\Service;


class jpegConverterService
{
    // Paramètre initialisé dans services.yaml
    private $uploadPath;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * 1 / Convertisseur d'image Base64 vers jpeg
     * 2 / On stocke le fichier dans uploadPath
     * 3 / On retourne le nom du fichier
     * @param string
     * @return string
     */
    public function convertBase64ToJgeg (string $base64):string
    {   
        $firstTreatment = str_replace('data:image/jpeg;base64,', '', $base64); // 1er traitement de la string base64
        $secondTreatement = str_replace(' ', '+', $firstTreatment);  // 2eme traitement de la string base64
        $jpegFile = base64_decode($secondTreatement); // on encode en jpeg => return string correspondant au code jpeg (on a un fichier.jpeg)
        
        $namedJpegFile = uniqid() . '.jpeg'; // on crée un nom unique => return string xxxxxx.jpg
        $absolutePath =  $this->uploadPath . $namedJpegFile; // on reconstruit le chemin vers rep : assets/upload/pictures/xxxxxx.jpg 
        file_put_contents($absolutePath, $jpegFile); //on déplace dans le rep : $destination le fichier jpg : $jpgFile
        
        return $namedJpegFile; //on retourne la valeur string de $namedJpegFile pour la persister en Bdd si on utilise le service
    }

}

