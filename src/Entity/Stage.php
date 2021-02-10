<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departureDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivalDate;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $seat;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $gate;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $baggageDrop;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Travel::class, mappedBy="travelStage")
     */
    private $travel;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="stagesDeparture")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departure;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="stagesArrival")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrival;

    public function __construct()
    {
        $this->travel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getSeat(): ?string
    {
        return $this->seat;
    }

    public function setSeat(?string $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getGate(): ?string
    {
        return $this->gate;
    }

    public function setGate(?string $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    public function getBaggageDrop(): ?string
    {
        return $this->baggageDrop;
    }

    public function setBaggageDrop(?string $baggageDrop): self
    {
        $this->baggageDrop = $baggageDrop;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTravel(): Collection
    {
        return $this->travel;
    }

    public function addTravel(Travel $travel): self
    {
        if (!$this->travel->contains($travel)) {
            $this->travel[] = $travel;
            $travel->addTravelStage($this);
        }

        return $this;
    }

    public function removeTravel(Travel $travel): self
    {
        if ($this->travel->removeElement($travel)) {
            $travel->removeTravelStage($this);
        }

        return $this;
    }

    public function getDeparture(): ?City
    {
        return $this->departure;
    }

    public function setDeparture(?City $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?City
    {
        return $this->arrival;
    }

    public function setArrival(?City $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }
}
