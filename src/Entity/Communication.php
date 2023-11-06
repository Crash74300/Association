<?php

namespace App\Entity;

use App\Repository\CommunicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CommunicationRepository::class)]
#[Vich\Uploadable]
class Communication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'recipe_images', fileNameProperty: 'image1')]
    private ?File $imageFile1 = null;
    #[Vich\UploadableField(mapping: 'recipe_images', fileNameProperty: 'image2')]
    private ?File $imageFile2 = null;

    #[ORM\Column(nullable: true)]
    private ?string $image1 = null;
    #[ORM\Column(nullable: true)]
    private ?string $image2 = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_stop = null;

    #[ORM\Column(nullable: true)]
    private ?bool $finish = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setImageFile1(?File $imageFile1 = null): void
    {
        $this->imageFile1 = $imageFile1;

        if (null !== $imageFile1) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTimeImmutable();
        }
    }
    public function setImageFile2(?File $imageFile2 = null): void
    {
        $this->imageFile2 = $imageFile2;

        if (null !== $imageFile2) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }

    public function setImage1(?string $image1): void
    {
        $this->image1 = $image1;
    }
    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

    public function setImage2(?string $image2): void
    {
        $this->image2 = $image2;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }
    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateStop(): ?\DateTimeInterface
    {
        return $this->date_stop;
    }

    public function setDateStop(\DateTimeInterface $date_stop): static
    {
        $this->date_stop = $date_stop;

        return $this;
    }

    public function isFinish(): ?bool
    {
        return $this->finish;
    }

    public function setFinish(?bool $finish): static
    {
        $this->finish = $finish;

        return $this;
    }
}
