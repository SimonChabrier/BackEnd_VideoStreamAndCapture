<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    
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

}
