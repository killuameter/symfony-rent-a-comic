<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="Category")
 * @ORM\Entity(repositoryClass="App\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Serie", inversedBy="categories")
     */
    private $series;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255)
     */
    private $categoryName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    /**
     * Set series
     *
     * @param integer $series
     * @return Category
     */
    public function setSeries($series): Category
    {
        $this->series = $series;

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->series = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addSeries(Serie $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series->add($series);
        }

        return $this;
    }

    public function removeSeries(Serie $series): self
    {
        $this->series->removeElement($series);

        return $this;
    }
}
