<?php

namespace App\Entity;

use App\Repository\TravelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TravelRepository::class)
 */
class Travel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\Type(
     *     type="string",
     *     message="Le nom du voyage doit-être de type {{ type }}."
     * )
     * @Assert\Length(
     *     min="2",
     *     max="200",
     *     minMessage="Le nom du voyage doit contenir au moins {{ limit }} caractères",
     *     maxMessage="Le nom du voyage doit contenir au plus {{ limit }} caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="Le prix du voyage doit-être de type {{ type }}."
     * )
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Stage::class, inversedBy="travel")
     */
    private $travelStage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

    public function __construct()
    {
        $this->travelStage = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTravelStage(): Collection
    {
        return $this->travelStage;
    }

    public function addTravelStage(Stage $travelStage): self
    {
        if (!$this->travelStage->contains($travelStage)) {
            $this->travelStage[] = $travelStage;
        }

        return $this;
    }

    public function removeTravelStage(Stage $travelStage): self
    {
        $this->travelStage->removeElement($travelStage);

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
