<?php

namespace App\Entity;

use App\Repository\ElectronicParamsRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElectronicParamsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ElectronicParams
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $multipleOrNot;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=ElectronicParamsValues::class, mappedBy="param")
     */
    private $electronicParamsValues;

    /**
     * @ORM\ManyToOne(targetEntity=Electronic::class, inversedBy="params")
     */
    private $electronic;

    public function __construct()
    {
        $this->electronicParamsValues = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMultipleOrNot(): ?bool
    {
        return $this->multipleOrNot;
    }

    public function setMultipleOrNot(bool $multipleOrNot): self
    {
        $this->multipleOrNot = $multipleOrNot;

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
     * @return Collection|ElectronicParamsValues[]
     */
    public function getElectronicParamsValues(): Collection
    {
        return $this->electronicParamsValues;
    }

    public function addElectronicParamsValue(ElectronicParamsValues $electronicParamsValue): self
    {
        if (!$this->electronicParamsValues->contains($electronicParamsValue)) {
            $this->electronicParamsValues[] = $electronicParamsValue;
            $electronicParamsValue->setParam($this);
        }

        return $this;
    }

    public function removeElectronicParamsValue(ElectronicParamsValues $electronicParamsValue): self
    {
        if ($this->electronicParamsValues->removeElement($electronicParamsValue)) {
            // set the owning side to null (unless already changed)
            if ($electronicParamsValue->getParam() === $this) {
                $electronicParamsValue->setParam(null);
            }
        }

        return $this;
    }

    public function getElectronic(): ?Electronic
    {
        return $this->electronic;
    }

    public function setElectronic(?Electronic $electronic): self
    {
        $this->electronic = $electronic;

        return $this;
    }
}
