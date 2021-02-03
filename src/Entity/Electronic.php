<?php

namespace App\Entity;

use App\Repository\ElectronicRepository;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElectronicRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Electronic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue²
     * @ORM\Column(type="integer")
     * @Groups({"API"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"API"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="electronics")
     * @Groups({"API"})
     */
    private $mark;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="devices")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=ElectronicParams::class, mappedBy="electronic")
     */
    private $params;

    /**
     * @ORM\ManyToOne(targetEntity=ElectronicCategory::class, inversedBy="electronics")
     */
    private $category;


    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->params = new ArrayCollection();
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

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addElectronic($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeElectronic($this);
        }

        return $this;
    }

    /**
     * @return Collection|ElectronicParams[]
     */
    public function getParams(): Collection
    {
        return $this->params;
    }

    public function addParam(ElectronicParams $param): self
    {
        if (!$this->params->contains($param)) {
            $this->params[] = $param;
            $param->setElectronic($this);
        }

        return $this;
    }

    public function removeParam(ElectronicParams $param): self
    {
        if ($this->params->removeElement($param)) {
            // set the owning side to null (unless already changed)
            if ($param->getElectronic() === $this) {
                $param->setElectronic(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?ElectronicCategory
    {
        return $this->category;
    }

    public function setCategory(?ElectronicCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
