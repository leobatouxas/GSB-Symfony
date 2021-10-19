<?php

namespace App\Entity;

use App\Repository\StandardFeesLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandardFeesLineRepository::class)
 */
class StandardFeesLine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=StandardFees::class, inversedBy="standardFeesLines")
     */
    private $standardFees;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStandardFees(): ?StandardFees
    {
        return $this->standardFees;
    }

    public function setStandardFees(?StandardFees $standardFees): self
    {
        $this->standardFees = $standardFees;

        return $this;
    }
}
