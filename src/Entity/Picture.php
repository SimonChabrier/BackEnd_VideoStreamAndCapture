<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @ORM\OrderBy({"picture" = "DESC"})
     */
    private $picture;

    /**
     * Ici on passe eventPictureFile qui correspond à la propriété
     * user_picture en Bdd pour faire le lien
     * entre le fichier téléchargé soit la valeur de $eventPictureFile
     * 
     * @Vich\UploadableField(mapping="user_picture", fileNameProperty="picture")
     * @var File
     */
    private $pictureFile;

    /**
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lng;

    
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

        $this->picture = $picture;
  
        return $this;
    }

    /**
     * Set the value of PictureFile
     * @param  File  $pictureFile
     * @return  self
     */ 
    public function setPictureFile(File $pictureFile = null)
    {
        $this->picture = $pictureFile;

        if ($pictureFile) {

            //todo faire mon persist ici ?

           // $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * Get the value of PictureFile
     * @return  File
     */ 
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

}
