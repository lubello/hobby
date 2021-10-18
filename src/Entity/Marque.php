<?php

namespace App\Entity;

use App\Annotation\Uploadable;
use App\Annotation\UploadableField;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 * @Uploadable()
 */
class Marque
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deletedBy;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="marque")
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="marques")
     * @Assert\NotBlank()
     */
    private $ville;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;
    /**
     * @UploadableField(name="filename", path="Uploads/Marque")
     * @Assert\Image(maxHeight="4000", maxWidth="4000")
     */
    private $file;


    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $siteWeb;



    public function __construct() {
        $this->articles = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setCreatedBy(0);
    }

    public function getId(): ?int {
        return $this->id;
    }


    public function getNom(): ?string {
        return $this->nom;
    }
    public function setNom(string $nom): self {
        $this->nom = $nom;
        return $this;
    }


    public function getDescription(): ?string {
        return $this->description;
    }
    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }



    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }


    public function getDeletedAt(): ?\DateTimeInterface {
        return $this->deletedAt;
    }
    public function setDeletedAt(?\DateTimeInterface $deletedAt): self {
        $this->deletedAt = $deletedAt;
        return $this;
    }


    public function getCreatedBy(): ?int {
        return $this->createdBy;
    }
    public function setCreatedBy(int $createdBy): self {
        $this->createdBy = $createdBy;
        return $this;
    }


    public function getUpdatedBy(): ?int {
        return $this->updatedBy;
    }
    public function setUpdatedBy(?int $updatedBy): self {
        $this->updatedBy = $updatedBy;
        return $this;
    }


    public function getDeletedBy(): ?int
    {
        return $this->deletedBy;
    }
    public function setDeletedBy(?int $deletedBy): self
    {
        $this->deletedBy = $deletedBy;

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

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setMarque($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getMarque() === $this) {
                $article->setMarque(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

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
     * @param $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }



    public function getSiteWeb(): ?string {
        return $this->siteWeb;
    }
    public function setSiteWeb(?string $siteWeb): self {
        $this->siteWeb = $siteWeb;
        return $this;
    }


}
