<?php

// https://symfony.com/doc/5.4/event_dispatcher.html#event-aliases
// https://www.php.net/manual/en/function.unlink.php

namespace App\EventSubscriber;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{   

    /**
     * Variable globale déclarée dans services.yaml 
     * contenant le chemin vers le path local $uploadPath => assets/upload/pictures/
     * @var string
     */
    private $uploadPath;

     /**
     * Variable globale déclarée dans services.yaml 
     * contenant le chemin vers le path local $cachePath => media/cache/portrait/assets/upload/pictures/
     * @var string
     */
    private $cachePath;

    // On passe au contructeur les propriétés $uploadPath et $cachePath
    // pour y accèder dans le contexte de ce Subscriber
    public function __construct(string $uploadPath, string $cachePath)
    {
        $this->uploadPath = $uploadPath;
        $this->cachePath = $cachePath;
    }

    // On souscrit à l'événement BeforeEntityDeletedEvent de EasyAdmin 
    // et on exécute le méthode deletePicture sur chaque événement
    // pour supprimer du repertoire de stockage et de cache
    // chaque fichier image lié à l'image supprimée depuis EasyAdmin.
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityDeletedEvent::class => ['deletePicture'],
        ];
    }

    public function deletePicture(BeforeEntityDeletedEvent $event)
    {   
        // On récupère une instance de la Classe Picture pour accèder à ses méthodes sur $entity
        $entity = $event->getEntityInstance();

        // On vérifie qu'il s'agit bien de l'entité Picture.
        if (!($entity instanceof Picture)) {
            return;
        }

        // On supprime chaque fichier image du rep $uploadPath et du rep $cachePath
        // avec unlink(le chemin du repertoire qu'on concaténe à la valeur de pictureFile)
        // On cibler systèmatiquement les fichiers correspondant à l'objet Picture courant.
        unlink($this->uploadPath . $entity->getPictureFile());
        unlink($this->cachePath . $entity->getPictureFile());
        unlink($this->cachePath . $entity->getPictureFile() . '.webp');
    }
}