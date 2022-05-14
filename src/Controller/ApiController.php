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
     * @Route("/api/post", name="app_api", methods={"POST"})
     */
    public function getPicturesFromFront(
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response
    {   
       
        $data = $request->getContent();
    
        $picture = $serializer->deserialize($data, Picture::class, 'json');
       
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
        );
    }

    /**
     * @Route("/api/get", name="app_pictures", methods={"GET"})
     */
    public function sendAllPicturesToFront(PictureRepository $pictureRepository): Response
    {
        // on renvoit une réponse de type JsonResponse
        // le contentType Json dans les headers est ajouté automatiquement par $this->json
        // dans le picture repository j'ai fait une méthode qui retourne les images par ordre DESC
        return $this->json(
        $pictureRepository->findAllPictureOrderByDesc(),
        // status code http
        200,
        //headers
        [],
        // Contexte
        ['groups' => 'api_post'],
        );
    }

   
}