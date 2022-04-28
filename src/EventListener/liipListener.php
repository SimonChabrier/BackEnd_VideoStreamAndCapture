<?php

namespace App\EventListener;

use App\Entity\Picture;
use Liip\ImagineBundle\Service\FilterService;

// todo ATTENTION CE LISTENER A ETE RENOMME ET CA A CREE UN CACHE OU UEN ENREGISTREMENT QUELQUE PART !
// todo  IL EST REFERENCE AVEC UN 'l' MINUSCULE A liip  
// todo IL FAUT LE GARDER PARTOUT AVEC CE NOM ICI ET DANS service.yaml EN liipListener.php SANS L MAJUSCULE A liip ! 

//* Ici j'utilise l'injection de service FilterService de liip imagine bundle - déclaré ensuite dans services.yaml
//* Je crée ma méthode sur l'entité Picture et je l'attache aux evenements doctrine sur cette classe.
//* cette méthode et sa logique est donc appellée à chaque événement doctrine sur cette classe.
//* A chaque upload de fichier, le service liip passé dans la méthode crée le cache de l'image.
//* Je pourrais aussi utiliser ça pour créer le cache à l'upload directement dans un contrôleur
//* Ce me permet de ne pas générer le cache côté front lors de la requête pour servir la page.
//* C'est un otimisation pour l'utilisateur qui aura un fichier immédiattement disponnible.

class liipListener 
{
    /**
     * @var string
     */
    private $uploadParameter;

    // private $filterService; 
    //* Pas besoin de paramètre spécifique - le service est directement reconnu parce que apellé dans services.yaml suivant la doc liip
    //* Donc on utilise l'injection de dépendance directement - comme pour les autres classes de symfony.

    public function __construct(FilterService $filterService, string $uploadParameter)
    {
        $this->filterService = $filterService;
        $this->uploadParameter = $uploadParameter;
    }
    /**
     * Il faut ensuite regarder les paramètres du fichier services.yaml pour voir comment
     * est apellé cette méthode et à quel moment dans le parcours doctrine
     * @param Picture $picture
     * @return void
     */
    public function cachePictureFile(Picture $picture)
    {   
        $this->filterService->getUrlOfFilteredImage($this->uploadParameter . $picture->getPictureFile(), 'portrait'); 
        //je reconstruit l'url + le nom duu fichier à traiter à l'event Doctrine et je lui passe mon filtre liip
    }
}