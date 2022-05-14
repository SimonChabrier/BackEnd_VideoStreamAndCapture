<?php

namespace App\EventListener;

use App\Entity\Picture;
use App\Service\jpegConverterService;


class PictureListener 
{
    private $img;


    // ici a chaque mise à jour d'une Picture je vais demander de me créer le Fichier jpeg
    // en apellant mon service jpegConverterService
    // le paramètrage de ce listener est déclaré dans le fichier services.yaml

    // j'apelle le contructeur pour accèder aux propriétés de jpegConverterService service
    public function __construct(jpegConverterService $img)
    {
        $this->img = $img; 
  
    }

    /**
     * Il faut ensuite regarder les paramètres du fichier services.yaml pour voir comment
     * est apellé cette méthode et à quel moment dans le parcours doctrine
     * @param Picture $picture
     * @return void
     */
    public function updatePictureFile(Picture $picture)
    {   
        $nullPicture = null;

        $pictureFile = $this->img->convertPictureService($picture->getPicture());
        $picture->setPictureFile($pictureFile);

        // le fichier Jpg est crée 
        // je sette la valeur de l'objet Picture persistée à null 
        $picture->setPicture($nullPicture);


        
    }
}