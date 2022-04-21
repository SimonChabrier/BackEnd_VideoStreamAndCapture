<?php

namespace App\Service;

//use App\Entity\Picture;
use App\Repository\PictureRepository;
//use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureConverter
{



    public function serviceBase64ToJpg(PictureRepository $pictureRepository) //: string
    {

        //todo il faut que je récupère le fichier base 64 en bdd 
        //todo il faut que je le convertisse
        //todo il faut que je déplace le résulatt de la convertion dans un dossier
        //todo il faut que je persiste le nom du fichier en BDD (dans le bon user)
        //todo il faut que je retourne en GET un groupe avec tout sauf le fichier BASE64
        //todo il faut que je crée ensuite le bon lien côté js


            $imgs = $pictureRepository->findPictureAndId();

            foreach($imgs as $img)
            {
                //$path = "assets/upload/pictures/";
        
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_en_base64 = base64_decode($image_parts[1]);
                $file = $img . uniqid() . '.jpeg';
                dump($file);
                file_put_contents($file, $image_en_base64);

            }
                

        ;
        }
    
}

// SELECT id, picture FROM picture