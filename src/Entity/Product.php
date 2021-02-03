<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $complet_description;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity=Electronic::class, inversedBy="products")
     */
    private $electronics;

    /**
     * @ORM\OneToMany(targetEntity=Files::class, mappedBy="product")
     */
    private $files;

    private $uploadedFiles;

    public function __construct()
    {
        $this->electronics = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->uploadedFiles = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */

    public function updatedTimestamps(): void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCompletDescription(): ?string
    {
        return $this->complet_description;
    }

    public function setCompletDescription(?string $complet_description): self
    {
        $this->complet_description = $complet_description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getElectronics(): Collection
    {
        return $this->electronics;
    }

    public function addElectronic(Electronic $electronic): self
    {
        if (!$this->electronics->contains($electronic)) {
            $this->electronics[] = $electronic;
        }

        return $this;
    }

    public function removeElectronic(Electronic $electronic): self
    {
        $this->electronics->removeElement($electronic);

        return $this;
    }


    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    public function addFile(UploadedFile $file)
    {
        
        if (!$this->uploadedFiles->contains($file)) {
            $this->uploadedFiles[] = $file;
        }

        return $this;
    }

    public function getFiles(){
        return $this->files;
    }

    public function pushFile(Files $file){

        if(!$this->files->contains($file)){
            $this->uploadedFiles[] = $file;
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        if ($this->Files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getProduct() === $this) {
                $file->setProduct(null);
            }
        }

        return $this;
    }
}
