<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $nationality;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Tour::class)]
    private $tours;

    public function __construct()
    {
        $this->tours = new ArrayCollection();
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

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection<int, Tour>
     */
    public function getTours(): Collection
    {
        return $this->tours;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tours->contains($tour)) {
            $this->tours[] = $tour;
            $tour->setCompany($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            // set the owning side to null (unless already changed)
            if ($tour->getCompany() === $this) {
                $tour->setCompany(null);
            }
        }

        return $this;
    }

    public function getAllStops(): Collection
    {
        $tours = $this->tours;
        $array = new ArrayCollection();

        foreach ($tours as $tour ){
            $recup = $tour->getStops();
            foreach ($recup as $stop ){
                $this->array[] = $stop;
            }
        }

        return $array;
    }

    public function getBiggestTour(): ?Tour
    {
        $tours = $this->tours;
        $biggestTour = new Tour();

        for ($i = 0; $i < count($tours); $i++){
            $compare1 = $tours[$i];
            $compare2 = $tours[$i+1];

            if ($compare1->getCapacity() > $compare2->getCapacity()){
                $biggestTour = $compare1;
            } else {
                $biggestTour = $compare2;
            }
        }

        return $biggestTour;
    }
}
