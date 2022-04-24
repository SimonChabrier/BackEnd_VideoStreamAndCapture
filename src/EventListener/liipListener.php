<?php

namespace App\EventListener;

use App\Entity\Picture;
use Liip\ImagineBundle\Service\FilterService;


class LiipListener 

{
    private $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }
    /**
     * Il faut ensuite regarder les paramètres du fichier services.yaml pour voir comment
     * est apellé cette méthode et à quel moment dans le parcours doctrine
     * @param Picture $picture
     * @return void
     */
    public function cachePictureFile(Picture $picture)
    {   
        $pictureName = $picture->getPictureFile(); // je récupère le nom du fichier
        $path = '/assets/upload/pictures/'; //je défini le path local
        $this->filterService->getUrlOfFilteredImage($path.$pictureName, 'portrait');
        
        //$resourcePath = $this->filterService->getUrlOfFilteredImage($path.$pictureName, 'portrait');
        //return $resourcePath;
    }
}
