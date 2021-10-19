<?php

namespace App\Entity;

use App\Repository\StandardFeesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandardFeesRepository::class)
 */
class StandardFees
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
     * @ORM\Column(type="integer")
     */
    private $unitAmount;

    /**
     * @ORM\OneToMany(targetEntity=StandardFeesLine::class, mappedBy="standardFees")
     */
    private $standardFeesLines;

    public function __construct()
    {
        $this->standardFeesLines = new ArrayCollection();
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

    public function getUnitAmount(): ?int
    {
        return $this->unitAmount;
    }

    public function setUnitAmount(int $unitAmount): self
    {
        $this->unitAmount = $unitAmount;

        return $this;
    }

    /**
     * @return Collection|StandardFeesLine[]
     */
    public function getStandardFeesLines(): Collection
    {
        return $this->standardFeesLines;
    }

    public function addStandardFeesLine(StandardFeesLine $standardFeesLine): self
    {
        if (!$this->standardFeesLines->contains($standardFeesLine)) {
            $this->standardFeesLines[] = $standardFeesLine;
            $standardFeesLine->setStandardFees($this);
        }

        return $this;
    }

    public function removeStandardFeesLine(StandardFeesLine $standardFeesLine): self
    {
        if ($this->standardFeesLines->removeElement($standardFeesLine)) {
            // set the owning side to null (unless already changed)
            if ($standardFeesLine->getStandardFees() === $this) {
                $standardFeesLine->setStandardFees(null);
            }
        }

        return $this;
    }
}
