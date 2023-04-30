<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\Blogpost;
use App\Entity\Realisation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use symfony\component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $contenu;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Realisation $realisation = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Blogpost $blogpost = null;

    #[ORM\Column]
    private ?bool $isPublished = false;



    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }


       public function getId(): ?int
       {
           return $this->id;
       }

       public function getAuteur(): ?string
       {
           return $this->auteur;
       }

       public function setAuteur(string $auteur): self
       {
           $this->auteur = $auteur;

           return $this;
       }

        public function getContenu(): ?string
       {
           return $this->contenu;
       }

       public function setContenu(string $contenu): self
       {
           $this->contenu = $contenu;

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

       public function getRealisation(): ?Realisation
       {
           return $this->realisation;
       }

       public function setRealisation(?Realisation $realisation): self
       {
           $this->realisation = $realisation;

           return $this;
       }

       public function getBlogpost(): ?Blogpost
       {
           return $this->blogpost;
       }

       public function setBlogpost(?Blogpost $blogpost): self
       {
           $this->blogpost = $blogpost;

           return $this;
       }

       public function IsIsPublished(): ?bool
       {
           return $this->isPublished;
       }

       public function setIsPublished(bool $isPublished): self
       {
           $this->isPublished = $isPublished;

           return $this;
       }

       public function __toString()
       {
           return $this->auteur;
       }
}
