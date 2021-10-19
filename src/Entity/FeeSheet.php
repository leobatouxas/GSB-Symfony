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
     * @ORM\Column(type="integer")
     */
    private $validAmount;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="feeSheets")
     */
    private $employees;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="FeeSheets")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=StandardFeesLine::class, mappedBy="feeSheets")
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

    public function getValidAmount(): ?int
    {
        return $this->validAmount;
    }

    public function setValidAmount(int $validAmount): self
    {
        $this->validAmount = $validAmount;

        return $this;
    }

    public function getEmployees(): ?Employee
    {
        return $this->employees;
    }

    public function setEmployees(?Employee $employees): self
    {
        $this->employees = $employees;

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
            $standardFeesLine->setFeeSheets($this);
        }

        return $this;
    }

    public function removeStandardFeesLine(StandardFeesLine $standardFeesLine): self
    {
        if ($this->standardFeesLines->removeElement($standardFeesLine)) {
            // set the owning side to null (unless already changed)
            if ($standardFeesLine->getFeeSheets() === $this) {
                $standardFeesLine->setFeeSheets(null);
            }
        }

        return $this;
    }
}
