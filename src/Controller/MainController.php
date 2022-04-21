<?php

namespace App\Controller;
use App\Entity\Picture;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(
    PictureRepository $pictureRepository,
    EntityManagerInterface $doctrine): Response
    {
            // je récupère tous mes objets
            $imgs = $pictureRepository->findPictureAndIdObjets();
            //je boucle dessus et converti les images. 
            foreach($imgs as $obj)
            {  
                $id = $obj->getId();
                $img = $obj->getPicture();
                
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $newFileName = uniqid() . '.jpeg';
                $file = "./assets/upload/pictures/" . $newFileName;
                $success = file_put_contents($file, $data); 
                
                $img = $obj->setPictureFile($newFileName);

                $doctrine->persist($img);
                $doctrine->flush();

            }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
             //compact('imgs')
        ]);

    }
}
