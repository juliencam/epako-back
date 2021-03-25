<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $addressComplement;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $logo;

    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":1})
     * @Groups("api_place_read")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="places")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity=PlaceCategory::class, inversedBy="places")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     */
    private $placeCategory;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="place", cascade={"remove"})
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=ProductCategory::class, mappedBy="places")
     *
     */
    private $productCategories;

    /**
     * @ORM\Column(type="string", length=620, nullable=true)
     * @Groups("api_place_browse")
     */
    private $url;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->productCategories = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;

        return $this;
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
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

    public function getPlaceCategory(): ?PlaceCategory
    {
        return $this->placeCategory;
    }

    public function setPlaceCategory(?PlaceCategory $placeCategory): self
    {
        $this->placeCategory = $placeCategory;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setPlace($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getPlace() === $this) {
                $review->setPlace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductCategory[]
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    public function addProductCategory(ProductCategory $productCategory): self
    {
        if (!$this->productCategories->contains($productCategory)) {
            $this->productCategories[] = $productCategory;
            $productCategory->addPlace($this);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): self
    {
        if ($this->productCategories->removeElement($productCategory)) {
            $productCategory->removePlace($this);
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    
}
