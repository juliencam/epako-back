<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 *
 * @see phpDocBlock of the Department
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_product_browse")
     * @Groups("api_product_category_read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups("api_product_browse")
     * @Groups("api_product_category_read")
     * @Assert\NotBlank
     * @Assert\Length(min=2, minMessage="Le nom doit contenir au moins 2 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups("api_product_browse")
     * @Groups("api_product_category_read")
     * @Assert\NotBlank
     * @Assert\Length(min=10, minMessage="Le content doit contenir au moins 10 caractères")
     */
    private $content;

    /**
     * @ORM\Column(type="float" ,options={"unsigned":true, "default":0})
     * @Groups("api_product_browse")
     * @Groups("api_product_category_read")
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="smallint" ,options={"unsigned":true, "default":1})
     * @Groups("api_product_browse")
     * @Assert\NotBlank
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("api_product_browse")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("api_product_browse")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=ProductCategory::class, inversedBy="products")
     * @Groups("api_product_browse")
     * @Assert\NotBlank
     * @Assert\Count(max=1, maxMessage="Le produit doit faire référence à une seule subcategory")
     */
    private $productCategories;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="product", orphanRemoval=true)
     * @Groups("api_product_browse")
     * @Groups("api_product_category_read")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups("api_product_browse")
     * @Groups("api_product_category_read")
     * @Assert\NotBlank
     */
    private $brand;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $tendanceBoolean;

    public function __construct()
    {
        $this->productCategories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->tendanceBoolean = false;
        $this->status = 1;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    /**
     * Update the updatedAt field before the update
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
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
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): self
    {
        $this->productCategories->removeElement($productCategory);

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

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

    public function getTendanceBoolean(): ?bool
    {
        return $this->tendanceBoolean;
    }

    public function setTendanceBoolean(?bool $tendanceBoolean): self
    {
        $this->tendanceBoolean = $tendanceBoolean;

        return $this;
    }

}
