<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cheese", mappedBy="category")
     */
    private $cheese_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->cheese_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|cheese[]
     */
    public function getCheeseId(): Collection
    {
        return $this->cheese_id;
    }

    public function addCheeseId(cheese $cheeseId): self
    {
        if (!$this->cheese_id->contains($cheeseId)) {
            $this->cheese_id[] = $cheeseId;
            $cheeseId->setCategory($this);
        }

        return $this;
    }

    public function removeCheeseId(cheese $cheeseId): self
    {
        if ($this->cheese_id->contains($cheeseId)) {
            $this->cheese_id->removeElement($cheeseId);
            // set the owning side to null (unless already changed)
            if ($cheeseId->getCategory() === $this) {
                $cheeseId->setCategory(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
