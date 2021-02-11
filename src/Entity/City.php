<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
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
     *     message="Le nom de ville doit-être de type {{ type }}."
     * )
     * @Assert\Length(
     *     min="3",
     *     max="200",
     *     minMessage="Le nom de ville doit contenir au moins {{ limit }} caractères",
     *     maxMessage="Le nom de ville doit contenir au plus {{ limit }} caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=2)
     * @Assert\Type(
     *     type="string",
     *     message="Le tag du pays doit-être de type {{ type }}."
     * )
     * @Assert\Length(
     *     min="2",
     *     max="2",
     *     minMessage="Le tag du pays doit contenir au moins {{ limit }} caractères",
     *     maxMessage="Le tag du pays doit contenir au plus {{ limit }} caractères",
     * )
     */
    private $countryTag;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="departure", orphanRemoval=true)
     */
    private $stagesDeparture;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="arrival", orphanRemoval=true)
     */
    private $stagesArrival;

    public function __construct()
    {
        $this->stagesDeparture = new ArrayCollection();
        $this->stagesArrival = new ArrayCollection();
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

    public function getCountryTag(): ?string
    {
        return $this->countryTag;
    }

    public function setCountryTag(string $countryTag): self
    {
        $this->countryTag = $countryTag;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStagesDeparture(): Collection
    {
        return $this->stagesDeparture;
    }

    public function addStageDeparture(Stage $stage): self
    {
        if (!$this->stagesDeparture->contains($stage)) {
            $this->stagesDeparture[] = $stage;
            $stage->setDeparture($this);
        }

        return $this;
    }

    public function removeStageDeparture(Stage $stageDeparture): self
    {
        if ($this->stagesDeparture->removeElement($stageDeparture)) {
            // set the owning side to null (unless already changed)
            if ($stageDeparture->getDeparture() === $this) {
                $stageDeparture->setDeparture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStagesArrival(): Collection
    {
        return $this->stagesArrival;
    }

    public function addStageArrival(Stage $stage): self
    {
        if (!$this->stagesArrival->contains($stage)) {
            $this->stagesArrival[] = $stage;
            $stage->setArrival($this);
        }

        return $this;
    }

    public function removeStageArrival(Stage $stage): self
    {
        if ($this->stagesDeparture->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getArrival() === $this) {
                $stage->setArrival(null);
            }
        }

        return $this;
    }
}
