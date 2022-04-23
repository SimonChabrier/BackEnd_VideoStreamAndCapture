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
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $newFileName = uniqid() . '.jpeg';
        $file = "./assets/upload/pictures/" . $newFileName;
        $success = file_put_contents($file, $data);      

        return $newFileName;
    }
}


