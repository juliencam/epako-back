<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 * Update the updatedAt field for the update
 *
 * @see https://symfony.com/doc/current/doctrine/events.html#doctrine-lifecycle-callbacks
 * @see https://symfony.com/doc/current/doctrine/events.html
 * use for the updatedAt
 * @ORM\HasLifecycleCallbacks()
 */

class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_department_browse")
     * @Groups("api_place_category_read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_department_browse")
     * @Groups("api_place_category_read")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=7, unique=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_department_browse")
     * @Groups("api_place_category_read")
     * @Assert\NotBlank
     */
    private $postalcode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="department")
     */
    private $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
        $this->createdAt = new \DateTime();
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

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Update the updatedAt field before the update
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setDepartment($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getDepartment() === $this) {
                $place->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * allows to return a string if we want to display the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->postalcode . " - " . $this->name;
    }
}
