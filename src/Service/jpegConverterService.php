<?php

namespace App\Service;

//todo normalment ici je gère uniquement la logique de convertion
//todo je rentre une string en entrée et je récupère le résultat en retour
//todo au passage le fichier doit être crée et déplacé dans le dossier

class jpegConverterService
{
    //une propriété qui attent de prendre une valeur depuis un listener!
    // le listener va être placé sur un événement Doctrine et c'ets là que je
    // vais initialiser la valeur de $pictdata
    //todo initialiser $pictdate avec la valeur de $picture->getPicture()
    //* ce sont les data Base64 de la BDD qui sont retournées par ->getPicture()

    private $pictdata;

    public function __construct(string $pictdata)
    {   
        $this->pictdata = $pictdata;
    }

      /**
     * Mon Service jpegConverter
     * A lappel de cette méthode, je peux passer une chaine en entrée
     * et elle retournera ue chaine traitée en sortie par les méthode de SluggerInterface de Symfony
     * @param string $input
     * @return string
     */
    protected function jpegConverter(string $pictdata): string
    {
        $img = str_replace('data:image/jpeg;base64,', '', $pictdata);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $fileName = uniqid() . '.jpeg';

        //todo attention nom du chemin ici
        $file = "public/assets/upload/pictures/" . $fileName;
        $success = file_put_contents($file, $data);
    
        return $fileName;

    }
    
}


