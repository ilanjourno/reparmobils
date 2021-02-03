<?php

namespace App\Entity;

use App\Repository\ElectronicCategoryRepository;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElectronicCategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ElectronicCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Electronic::class, mappedBy="category")
     * @Groups({"API"})
     */
    private $electronics;

    public function __construct()
    {
        $this->electronics = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->name;
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

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Electronic[]
     */
    public function getElectronics(): Collection
    {
        return $this->electronics;
    }

    public function addElectronic(Electronic $electronic): self
    {
        if (!$this->electronics->contains($electronic)) {
            $this->electronics[] = $electronic;
            $electronic->setCategory($this);
        }

        return $this;
    }

    public function removeElectronic(Electronic $electronic): self
    {
        if ($this->electronics->removeElement($electronic)) {
            // set the owning side to null (unless already changed)
            if ($electronic->getCategory() === $this) {
                $electronic->setCategory(null);
            }
        }

        return $this;
    }

}
