<?php

// https://symfony.com/doc/5.4/event_dispatcher.html#event-aliases

namespace App\EventSubscriber;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{   


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

        
        // ça ça marche
        //$fileToDelete = 'assets/upload/pictures/' . '626ac1c99d4ca.jpeg' ;

        $path = 'assets/upload/pictures/';
        $image = $entity->getPictureFile();
        // $image = $this->getPictureFile();        
        //$fileToDelete = $this->getParameter('picture_directory') . $pictureFile->getPictureFile() ;
        
        $fileToDelete = $path.$image;
        unlink($fileToDelete);
    }
}