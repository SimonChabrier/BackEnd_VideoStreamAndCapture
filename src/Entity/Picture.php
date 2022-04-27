<?php

namespace App\Entity;
use App\Service\jpegConverterService;
use Symfony\Component\Serializer\Annotation\Groups as Groups;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\Serializer\Annotation\Groups;
// https://symfony.com/doc/current/serializer.html#using-serialization-groups-annotations

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * 
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

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
        //https://symfonycasts.com/screencast/easyadminbundle/upload
        //return sprintf('assets/upload/pictures/%s', $this->pictureFile);
    }

    public function setPictureFile(?string $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    //Pour Easy Admin
    public function __toString(): string
    {
        return $this->pictureFile;
    }
}