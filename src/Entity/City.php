<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{

    use ApiFields;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    #[ORM\Column(length: 255)]
    private ?string $siren = null;

    #[ORM\Column]
    private ?int $population = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: PostalCode::class)]
    private Collection $postalCodes;

    public function __construct()
    {
        $this->postalCodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }

    /**
     * @return Collection<int, PostalCode>
     */
    public function getPostalCodes(): Collection
    {
        return $this->postalCodes;
    }

    public function addPostalCode(PostalCode $postalCode): self
    {
        if (!$this->postalCodes->contains($postalCode)) {
            $this->postalCodes->add($postalCode);
            $postalCode->setCity($this);
        }

        return $this;
    }

    public function removePostalCode(PostalCode $postalCode): self
    {
        $this->postalCodes->removeElement($postalCode);

        return $this;
    }
}
