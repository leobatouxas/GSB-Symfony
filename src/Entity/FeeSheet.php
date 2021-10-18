<?php

namespace App\Entity;

use App\Repository\FeeSheetRepository;
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
}
