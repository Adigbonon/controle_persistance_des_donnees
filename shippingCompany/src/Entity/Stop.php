<?php

namespace App\Entity;

use App\Repository\StopRepository;
use Cassandra\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StopRepository::class)]
class Stop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\ManyToMany(targetEntity: Tour::class, mappedBy: 'stops')]
    private $tours;

    public function __construct()
    {
        $this->tours = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
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

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Tour>
     */
    public function getTours(): \Doctrine\Common\Collections\Collection
    {
        return $this->tours;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tours->contains($tour)) {
            $this->tours[] = $tour;
            $tour->addStop($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            $tour->removeStop($this);
        }

        return $this;
    }

    public function getAllCompanies(): Collection
    {
        $tours = $this->tours;
        $array = new ArrayCollection();

        foreach ($tours as $tour ){
            $recup = $tour->getCompany();
            foreach ($recup as $company ){
                $this->array[] = $company;
            }
        }

        return $array;
    }
}
