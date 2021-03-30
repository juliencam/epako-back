<?php

namespace App\Entity;

use App\Repository\PlaceCategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=PlaceCategoryRepository::class)
 */
class PlaceCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_browse")
     * @Groups("api_place_category_read")
     * @Groups("api_placecategory_browse_productcategory")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_browse")
     * @Groups("api_place_category_read")
     * @Groups("api_placecategory_browse_productcategory")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_browse")
     * @Groups("api_place_category_read")
     * @Assert\NotBlank
     */
    private $pictogram;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="placeCategory")
     * @Groups("api_place_category_read")
     * @Groups("api_placecategory_browse_productcategory")
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

    public function getPictogram(): ?string
    {
        return $this->pictogram;
    }

    public function setPictogram(string $pictogram): self
    {
        $this->pictogram = $pictogram;

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
            $place->setPlaceCategory($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getPlaceCategory() === $this) {
                $place->setPlaceCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
