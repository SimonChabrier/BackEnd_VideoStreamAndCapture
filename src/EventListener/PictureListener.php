<?php

namespace App\EventListener;

use App\Entity\Picture;
use App\Service\jpegConverterService;


class PictureListener 
{

    // ici a chaque mise à jour d'une Picture
    // je vais demander de me créer le Fichier jpeg
    // en apellant mon service jpegConverterService
    // le paramètrage de ce listener est déclaré dans le fichier services.yaml

    // j'apelle le contructeur pour accèder aux propriétés de jpegConverterService service
    public function __construct(jpegConverterService $jpegConverterService)
    {
        $this->jpegConverterService = $jpegConverterService; 
  
    }

    /**
     * Voir services.yaml
     * qui apelle cette méthode sur les evenements Doctrine
     * @param Picture $picture
     * @return void
     */
    public function updatePictureFile(Picture $picture)
    {   
        $pictureFile = $this->jpegConverterService->convertBase64ToJgeg($picture->getPicture());
        $picture->setPictureFile($pictureFile);
        
    }
}