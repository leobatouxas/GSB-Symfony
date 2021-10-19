<?php

namespace App\Entity;

use App\Repository\StandardFeesRepository;
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
}
