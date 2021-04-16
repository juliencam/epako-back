<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 * @Vich\Uploadable
 *
 * @see phpDocBlock of the Department
 * @ORM\HasLifecycleCallbacks()
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
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     * @Assert\Length(
     *      min = 2,
     *      max = 255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     * @Assert\Length(
     *      min = 2,
     *      max = 64)
     */
    private $addressComplement;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     * @Assert\Length(
     *      min = 2,
     *      max = 64)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     */
    private $logo;

    /**
    * @ORM\Column(type="string", length=255)
    * @var string
    * @Groups("api_place_browse")
    * @Groups("api_place_read")
    * @Groups("api_place_category_read")
    */
    private $image;

    /**
     * @see field $imageField of Image entity for the comments
     *
     * @Vich\UploadableField(mapping="place_logo", fileNameProperty="image")
     * @var File
     * @Assert\File( mimeTypes={"image/png", "image/jpg", "image/jpeg", "image/svg+xml", "image/svg", "text/plain" })
     */

    private $imageFile;
    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":1})
     * @Groups("api_place_read")
     * @Assert\NotBlank
     * @Assert\Range(
     *      min = 0,
     *      max = 1,
     * )
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
     * @Groups("api_place_browse_ByproductcategoryAndPostalCode")
     * @Groups("api_placecategory_browse_productcategory")
     * @Assert\NotBlank
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity=PlaceCategory::class, inversedBy="places")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Assert\NotBlank
     */
    private $placeCategory;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="place", cascade={"remove"})
     *
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=ProductCategory::class, mappedBy="places")
     *
     * @Groups("api_placecategory_browse_productcategory")
     * @Groups("api_place_browse_ByproductcategoryAndPostalCode")
     */
    private $productCategories;

    /**
     * @ORM\Column(type="string", length=620, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Assert\Url(
     *    protocols = {"http", "https"}
     * )
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_read")
     * @Assert\Length(min=5, minMessage="doit contenir au moins 5 caractères")
     * @Assert\NotBlank
     */
    private $content;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->productCategories = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->image = "default-image.jpg";
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

    public function setAddress(?string $address): self
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

    public function setCity(?string $city): self
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

    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if (null !== $imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage($image):self
    {
        $this->image = $image;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
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

    /**
     * Update the updatedAt field before the update
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * allows to return a string if we want to display the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
