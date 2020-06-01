<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag5;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTag1(): ?string
    {
        return $this->tag1;
    }

    public function setTag1(?string $tag1): self
    {
        $this->tag1 = $tag1;

        return $this;
    }

    public function getTag2(): ?string
    {
        return $this->tag2;
    }

    public function setTag2(?string $tag2): self
    {
        $this->tag2 = $tag2;

        return $this;
    }

    public function getTag3(): ?string
    {
        return $this->tag3;
    }

    public function setTag3(?string $tag3): self
    {
        $this->tag3 = $tag3;

        return $this;
    }

    public function getTag4(): ?string
    {
        return $this->tag4;
    }

    public function setTag4(?string $tag4): self
    {
        $this->tag4 = $tag4;

        return $this;
    }

    public function getTag5(): ?string
    {
        return $this->tag5;
    }

    public function setTag5(?string $tag5): self
    {
        $this->tag5 = $tag5;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
