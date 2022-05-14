<?php
// déplacement vers et/ou création de repertoire
// https://www.php.net/manual/en/function.file-put-contents.php

namespace App\Service;


class jpegConverterService
{
    // Paramètre initialisé dans services.yaml
    // contenant le repertoire local dans lequel
    // on déplace le fichier .jpeg crée dans la logique de 
    // la méthode convertBase64ToJgeg
    private $uploadPath;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * Convertisseur d'image Base64 vers jpeg
     * traite le fichier base64 pour le convertir en jpg et le déplace 
     * dans le repertoire défini dans la variable $uploadPath
     * @param string $img
     * @return string
     */
    public function convertBase64ToJgeg (string $img):string
    {   

        $img = str_replace('data:image/jpeg;base64,', '', $img); // 1er traitement du fichier base64
        $img = str_replace(' ', '+', $img);  // 2eme traitement du fichier base64
        $file = base64_decode($img); // on decode vers un format jpg. $data est maintenant le fichier jpg
        $pictureFile = uniqid() . '.jpeg'; // on crée aléatoirement un nom unique xxxxxx.jpg
        $destination =  $this->uploadPath . $pictureFile; // on lui donne la valeur à écrire dans le rep : assets/upload/pictures/xxxxxx.jpg en concaténant
        file_put_contents($destination, $file); //on déplace dans le rep : $destination le fichier jpg : $data

        return $pictureFile; //on retourne la valeur string de $pictureFile pour la persister en Bdd si on utilise le service
    }

    /**
     * Récupère la valeur du paramètre 'picture_directory' déclaré dans services.yaml
     * https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

}

