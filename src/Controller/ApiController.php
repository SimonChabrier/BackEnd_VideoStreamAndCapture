<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="app_api", methods={"GET", "POST"})
     */
    public function getPicturesFromJsPost(
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response
    {
        $data = $request->getContent();
        
        $picture = $serializer->deserialize($data, Picture::class, 'json');
        
        //todo il faudrait convertir l'image et la persister
        $errors = $validator->validate($picture);

        if (count($errors) > 0) {
            // les messages d'erreurs sont à définir dans les asserts de l'entité Picture
            // Ex: @Assert\NotBlank(message = "Mon message")
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        
        $doctrine->persist($picture);
        
        $doctrine->flush();


        return $this->json(
            $picture,
            Response::HTTP_CREATED,
            [],
            // ici dans insomnia à gauche je ne verrai que les infos que j'ai associé au groupe 'mongroupe'
            // par contre celui qui fait le send peut remplir toutes les propriétés de l'objet
            // il faut donc lui fournir le détail des propriétés pour qu'il puisse faire une requête complète et valide
            //['groups' => ['mongroupe']]
        );
    }

    /**
     * @Route("/getpictures", name="app_pictures", methods={"GET"})
     */
    public function sendAllPicturesFromDataBase(PictureRepository $pictureRepository): Response
    {
        // on renvoit une réponse de type JsonResponse
        // le contentType Json dans les headers est ajouté automatiquement par $this->json
        // dans le picture repository j'ai fait une méthode qui retourne les images par ordre DESC
        return $this->json(
            $pictureRepository->findAllPictureOrderByDesc(),
        // status code http
            200,
        // HTTP headers dans mon cas il n'y en a pas de spécifique à envoyer
            [],
        // Contexte de serialisation, les groups de propriété que l'on veux serialiser si on a fait des groupes
            //['groups'=> 'groupe_x']
        );
    }

   
}