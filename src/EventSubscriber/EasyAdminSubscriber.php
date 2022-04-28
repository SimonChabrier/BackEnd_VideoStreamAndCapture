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
     * @var string
     */
    private $pathParameter;

     /**
     * @var string
     */
    private $cacheParameter;

    public function __construct(string $pathParameter, string $cacheParameter)
    {
        $this->pathParameter = $pathParameter;
        $this->cacheParameter = $cacheParameter;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityDeletedEvent::class => ['deletePicture'],
        ];
    }

    public function deletePicture(BeforeEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Picture)) {
            return;
        }
        // On supprime le fichir du disque si on supprime la picture dans l'admin panel.
        unlink($this->pathParameter . $entity->getPictureFile());
        unlink($this->cacheParameter . $entity->getPictureFile());
        unlink($this->cacheParameter . $entity->getPictureFile() . '.webp');
    }
}