<?php

namespace App\Entity;

use App\Repository\FeeSheetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeeSheetRepository::class)
 */
class FeeSheet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDocuments;

    /**
     * @ORM\Column(type="float")
     */
    private $validAmount;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="FeeSheets")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=VariableFeesLine::class, mappedBy="feeSheet", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $variableFeesLines;

    /**
     * @ORM\OneToMany(targetEntity=StandardFeesLine::class, mappedBy="feeSheet")
     */
    private $standardFeesLines;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="FeeSheets")
     */
    private $employee;

    public function __construct()
    {
        $this->variableFeesLines = new ArrayCollection();
        $this->standardFeesLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbDocuments(): ?int
    {
        return $this->nbDocuments;
    }

    public function setNbDocuments(int $nbDocuments): self
    {
        $this->nbDocuments = $nbDocuments;

        return $this;
    }

    public function getValidAmount(): ?float
    {
        return $this->validAmount;
    }

    public function setValidAmount(float $validAmount): self
    {
        $this->validAmount = $validAmount;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|VariableFeesLine[]
     */
    public function getVariableFeesLines(): Collection
    {
        return $this->variableFeesLines;
    }

    public function addVariableFeesLine(VariableFeesLine $variableFeesLine): self
    {
        if (!$this->variableFeesLines->contains($variableFeesLine)) {
            $this->variableFeesLines[] = $variableFeesLine;
            $variableFeesLine->setFeeSheet($this);
        }

        return $this;
    }

    public function removeVariableFeesLine(VariableFeesLine $variableFeesLine): self
    {
        if ($this->variableFeesLines->removeElement($variableFeesLine)) {
            // set the owning side to null (unless already changed)
            if ($variableFeesLine->getFeeSheet() === $this) {
                $variableFeesLine->setFeeSheet(null);
            }
        }

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
            $standardFeesLine->setFeeSheet($this);
        }

        return $this;
    }

    public function removeStandardFeesLine(StandardFeesLine $standardFeesLine): self
    {
        if ($this->standardFeesLines->removeElement($standardFeesLine)) {
            // set the owning side to null (unless already changed)
            if ($standardFeesLine->getFeeSheet() === $this) {
                $standardFeesLine->setFeeSheet(null);
            }
        }

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }
}
