<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateRepository::class)
 */
class State
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
     * @ORM\OneToMany(targetEntity=FeeSheet::class, mappedBy="state")
     */
    private $FeeSheets;

    public function __construct()
    {
        $this->FeeSheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->getName();
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

    /**
     * @return Collection|FeeSheet[]
     */
    public function getFeeSheets(): Collection
    {
        return $this->FeeSheets;
    }

    public function addFeeSheet(FeeSheet $feeSheet): self
    {
        if (!$this->FeeSheets->contains($feeSheet)) {
            $this->FeeSheets[] = $feeSheet;
            $feeSheet->setState($this);
        }

        return $this;
    }

    public function removeFeeSheet(FeeSheet $feeSheet): self
    {
        if ($this->FeeSheets->removeElement($feeSheet)) {
            // set the owning side to null (unless already changed)
            if ($feeSheet->getState() === $this) {
                $feeSheet->setState(null);
            }
        }

        return $this;
    }
}
