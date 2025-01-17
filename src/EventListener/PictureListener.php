<?php

namespace App\EventListener;

use App\Entity\Picture;
// Mon service => ma méthode
use App\Service\jpegConverterService;
// Service de Liip => ses methodes
use Liip\ImagineBundle\Service\FilterService;

class PictureListener
{

    /**
     * Paramètre déclaré => services.yaml
     * @var string
     */
    private $uploadPath;

    public function __construct(private jpegConverterService $jpegConverterService, private FilterService $liipFilterService, string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * services.yaml
     * apelle cette méthode sur les evenements Doctrine sur la class Picture
     * @param Picture $picture
     * @return void
     */
    public function processPictureFile(Picture $picture)
    {
        // On traite l'image avec la méthode de jpegConverterService pour convertir le Base64 et stocker le fichier dans un rep local
        $pictureFile = $this->jpegConverterService->convertBase64ToJgeg($picture->getPicture());
        // On set le nom de $pictureFile avec la valeur du return de convertBase64ToJgeg()
        $picture->setPictureFile($pictureFile);
        // On traite la mise en cache
        $this->liipFilterService->getUrlOfFilteredImage($this->uploadPath . $picture->getPictureFile(), 'portrait');
        // je reconstruit l'url + le nom du fichier à traiter et je lui passe mon filtre liip

    }
}
