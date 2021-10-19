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
     * @ORM\ManyToOne(targetEntity=FeeSheet::class, inversedBy="standardFeesLines")
     */
    private $feeSheets;

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

    public function getFeeSheets(): ?FeeSheet
    {
        return $this->feeSheets;
    }

    public function setFeeSheets(?FeeSheet $feeSheets): self
    {
        $this->feeSheets = $feeSheets;

        return $this;
    }
}
