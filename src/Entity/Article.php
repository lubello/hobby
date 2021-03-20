<?php

namespace App\Entity;

use App\Annotation\Uploadable;
use App\Annotation\UploadableField;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Uploadable()
 */
class Article
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
    private $ref1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="articles")
     */
    private $marque;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;


    /**
     * @UploadableField(name="filename", path="Uploads/Articles")
     * @Assert\Image(maxHeight="4000", maxWidth="4000")
     */
    private $file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteMin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag6;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codeBarNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeBarText;

    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     */
    private $typeCodeBar;






    public function __toString() {
        return $this->nom;
    }

    public function getId(): ?int {
        return $this->id;
    }



    public function getNom(): ?string {
        return $this->nom;
    }
    public function setNom(string $nom): self  {
        $this->nom = $nom;
        return $this;
    }



    public function getRef1(): ?string {
        return $this->ref1;
    }
    public function setRef1(?string $ref1): self {
        $this->ref1 = $ref1;
        return $this;
    }



    public function getRef2(): ?string {
        return $this->ref2;
    }
    public function setRef2(?string $ref2): self {
        $this->ref2 = $ref2;
        return $this;
    }



    public function getDescription(): ?string {
        return $this->description;
    }
    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }




    public function getMarque(): ?Marque {
        return $this->marque;
    }
    public function setMarque(?Marque $marque): self {
        $this->marque = $marque;
        return $this;
    }




    public function getTag1(): ?string {
        return $this->tag1;
    }
    public function setTag1(?string $tag1): self {
        $this->tag1 = $tag1;
        return $this;
    }




    public function getTag2(): ?string {
        return $this->tag2;
    }
    public function setTag2(?string $tag2): self {
        $this->tag2 = $tag2;
        return $this;
    }



    public function getTag3(): ?string {
        return $this->tag3;
    }
    public function setTag3(?string $tag3): self  {
        $this->tag3 = $tag3;
        return $this;
    }



    public function getTag4(): ?string {
        return $this->tag4;
    }
    public function setTag4(?string $tag4): self {
        $this->tag4 = $tag4;
        return $this;
    }



    public function getTag5(): ?string {
        return $this->tag5;
    }
    public function setTag5(?string $tag5): self {
        $this->tag5 = $tag5;
        return $this;
    }



    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getQuantiteMin(): ?int
    {
        return $this->quantiteMin;
    }

    public function setQuantiteMin(?int $quantiteMin): self
    {
        $this->quantiteMin = $quantiteMin;

        return $this;
    }

    public function getTag6(): ?string
    {
        return $this->tag6;
    }

    public function setTag6(?string $tag6): self
    {
        $this->tag6 = $tag6;

        return $this;
    }


    public function getUrl(): string {
        return $this->url;
    }
    public function setUrl(string $url): void {
        $this->url = $url;
    }




    public function getCodeBarNumber(): int {
        return $this->codeBarNumber;
    }
    public function setCodeBarNumber(int $codeBarNumber): void    {
        $this->codeBarNumber = $codeBarNumber;
    }

    public function getTypeCodeBar(): int {
        return $this->typeCodeBar;
    }
    public function setTypeCodeBar(int $typeCodeBar): void {
        $this->typeCodeBar = $typeCodeBar;
    }


    public function getCodeBarText(): string {
        return $this->codeBarText;
    }
    public function setCodeBarText(string $codeBarText): void {
        $this->codeBarText = $codeBarText;
    }



}
