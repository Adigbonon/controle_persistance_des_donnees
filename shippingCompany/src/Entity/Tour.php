<?php

namespace App\Entity;

use App\Repository\TourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TourRepository::class)]
class Tour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $mainEvent;

    #[ORM\Column(type: 'integer')]
    private $capacity;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'date')]
    private $startDate;

    #[ORM\Column(type: 'date')]
    private $stopDate;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'tours')]
    private $company;

    #[ORM\ManyToMany(targetEntity: Stop::class, inversedBy: 'tours')]
    private $stops;

    public function __construct()
    {
        $this->stops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainEvent(): ?string
    {
        return $this->mainEvent;
    }

    public function setMainEvent(string $mainEvent): self
    {
        $this->mainEvent = $mainEvent;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getStopDate(): ?\DateTimeInterface
    {
        return $this->stopDate;
    }

    public function setStopDate(\DateTimeInterface $stopDate): self
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Stop>
     */
    public function getStops(): Collection
    {
        return $this->stops;
    }

    public function addStop(Stop $stop): self
    {
        if (!$this->stops->contains($stop)) {
            $this->stops[] = $stop;
        }

        return $this;
    }

    public function removeStop(Stop $stop): self
    {
        $this->stops->removeElement($stop);

        return $this;
    }

}
