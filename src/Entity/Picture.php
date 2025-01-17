<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
//PictureRepository is used by EasyAdmin on Delete a Picture Objet
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups as Groups;


// use Symfony\Component\Serializer\Annotation\Groups;
// https://symfony.com/doc/current/serializer.html#using-serialization-groups-annotations

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_post"})
     */
    private $id;

  
    /**
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_post"})
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_post"})
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_post"})
     */
    private $pictureFile;

    // J'utilise $picture uniquement pour récupèrer le Base64 envpyé en Json
    // tout le traitement de cette valeur de l'objet Picture est traitée dans les services
    // pour créer $pictureFile en fin de process.
    private $picture;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {   
        return $this->picture;
    }


    public function setPicture(string $picture): self
    {   
        //On verifie la présence impérative de cette valeur dans 
        //le Json reçue sur /api/post
        $search ='data:image/jpeg;base64,';
        //$search ='Wahhhh';

        if(strpos($picture, $search) !== false)
        {
            $this->picture = $picture;
            return $this;
        }
        
        // sinon on ferme tout
        // j'ai bien un code retour 403
        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        // verif insomnia
        // dd($response);
        return $response->send();
    }

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
    }

    // Created by jpegConverterService on Doctrine Pre Update Event
    public function setPictureFile(?string $pictureFile): self
    {
        $this->pictureFile = $pictureFile;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set DateTime on Doctrine Prepersit 
     * Think to use "@ORM\HasLifecycleCallbacks()" at the top of this class !
     * 
     * @ORM\PrePersist
     * @param \DateTimeImmutable $createdAt
     * @return self
     */
     public function setCreatedAt()
     {
        $this->createdAt = new \DateTimeImmutable();
     }
    
    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {   
        // si on a pas de valeur de lat venant du front on setLat à null
        if ($lat === ""){
            $this->lat === null;
            return $this;
        }
        // sinon
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
         // si on a pas de valeur de lng venant du front on setLng à null
         if ($lng === ""){
            $this->lng === null;
            return $this;
        }
        // sinon
        $this->lng = $lng;

        return $this;
    }


}