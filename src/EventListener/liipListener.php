<?php

namespace App\EventListener;

use App\Entity\Picture;
use Liip\ImagineBundle\Service\FilterService;

// todo ATTENTION CE LISTENER A ETE RENOMME ET CA A CREE UN CACHE OU UEN ENREGISTREMENT QUELQUE PART !
// todo  IL EST REFERENCE AVEC UN 'l' MINUSCULE A liip  
// todo IL FAUT LE GARDER PARTOUT AVEC CE NOM ICI ET DANS service.yaml EN liipListener.php SANS L MAJUSCULE A liip ! 

// Process d'utilisation de la CLasse Liip FilterService qui pourrait être aussi utilisé directement dans contrôleur

class liipListener 
{
    /**
     *  Paramètre initialisé dans services.yaml
     * @var string
     */
    private $uploadPath;
    
    // Ce service de Liip est déclaré dans services.yaml
    // On utilise l'injection de dépendance de la classe FilterService dans $filterService.

    public function __construct(FilterService $filterService, string $uploadPath)
    {
        $this->filterService = $filterService;
        $this->uploadPath = $uploadPath;
    }
    /**
     * Voir services.yaml 
     * On apelle cette méthode sur les evenements Doctrine
     * @param Picture $picture
     * @return void
     */
    public function cachePictureFile(Picture $picture)
    {   
        $this->filterService->getUrlOfFilteredImage($this->uploadPath . $picture->getPictureFile(), 'portrait'); 
        //je reconstruit l'url + le nom du fichier à traiter et je lui passe mon filtre liip
    }
}