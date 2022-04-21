<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PictureConverter;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(PictureRepository $pictureRepository): Response
    {


        $imgs = $pictureRepository->findPictureAndIdObjets();
        
            foreach($imgs as $obj)
            {  

                $img = $obj->getPicture();
                
                $img = str_replace('data:image/jpeg;base64,', '', $img);
           
                $img = str_replace(' ', '+', $img);
                
                $data = base64_decode($img);
                
                $file = "./assets/upload/pictures/" . uniqid() . '.jpeg';
               
                $success = file_put_contents($file, $data);
               
      
            }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
             //compact('imgs')
        ]);

    }
}
