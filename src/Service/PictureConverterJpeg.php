<?php

namespace App\Service;

use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;

class PictureConverterJpeg
{

    private $pictureRepository;
    private $entityManagerInterface;

    public function __construct(PictureRepository $pictureRepository, EntityManagerInterface $entityManagerInterface)
    {
        $this->pictureRepository = $pictureRepository; 
        $this->entityManagerInterface = $entityManagerInterface;   

    }

    protected function jpegConverter()
    {

        $imgs = $this->pictureRepository->findAll();

        foreach ($imgs as $obj) {

            $pictureFile = $obj->getPictureFile();

            if ($pictureFile) {
                //je ne fait rien sil y a déjà une valeur dans pictureFile
            } else {

                $id = $obj->getId();
                $img = $obj->getPicture();
                    
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $newFileName = uniqid() . '.jpeg';
                //todo attention nom du chemin ici
                $file = "public/assets/upload/pictures/" . $newFileName;
                $success = file_put_contents($file, $data);
                    
                $img = $obj->setPictureFile($newFileName);
    
  
            }
        }

         $this->entityManagerInterface->flush();
      
    }
}
