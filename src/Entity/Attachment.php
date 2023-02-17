<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use App\Entity\Realisation;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AttachmentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AttachmentRepository::class)]
#[Vich\Uploadable]
class Attachment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'attachment_images', fileNameProperty:'image')]
    private ?File $imageFile = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    private ?Realisation $realisation = null;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


    public function setImageFile(File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->UpdatedAt = new \DateTime('now');
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
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

    public function getUpdatedAt(): ?DateTime
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTime $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

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
}
