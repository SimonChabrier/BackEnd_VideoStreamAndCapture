<?php

namespace App\Service;

class jpegConverterService
{

    /**
     * Convertisseur d'image
     * @param string $img
     */
    public function convertPictureService (string $img)
    {   
        //*marche si post depuis le front
        $directoryPath = 'assets/upload/pictures/';

        //*marche avec ma commande mais PAS si post depuis le front
        //$directoryPath = "public/assets/upload/pictures/";

        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $pictureFile = uniqid() . '.jpeg'; // ici j'ai mon image seule
        $file =  $directoryPath . $pictureFile; //ici je la déplace
        $success = file_put_contents($file, $data);      

        return $pictureFile;
    }
}


