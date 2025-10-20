<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="Book")
 * @ORM\Entity(repositoryClass="App\Entity\BookRepository")
 */
class Book
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="books")
     */
    private $serie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelBookAuthor", mappedBy="books")
     */
    private $rel;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cart", mappedBy="books")
     */
    private $carts;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255,nullable=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255)
     */
    private $cover;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPage", type="integer",nullable=true)
     */
    private $nbPage;

    /**
     * @var string
     *
     * @ORM\Column(name="editor", type="string", length=255)
     */
    private $editor;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime")
     */
    private $dateModified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublished", type="datetime",nullable=true)
     */
    private $datePublished;

    /**
     *  @var interger
     *
     *  @ORM\Column(name="seriePosition", type="integer",nullable=true)
     */
    private $seriePosition;

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Set Id
     * @param integer $id
     * @return Book
     */
    public function setId($id): Book
    {
        $this->id = $id;
        
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setNbPage(?int $nbPage): self
    {
        $this->nbPage = $nbPage;

        return $this;
    }

    public function getNbPage(): ?int
    {
        return $this->nbPage;
    }

    public function setEditor(string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDatePublished(?\DateTimeInterface $datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    /**
     * Set carts
     *
     * @param integer $carts
     * @return Book
     */
    public function setCarts($carts): Book
    {
        $this->carts = $carts;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function setSeriePosition(?int $seriePosition): self
    {
        $this->seriePosition = $seriePosition;

        return $this;
    }

    public function getSeriePosition(): ?int
    {
        return $this->seriePosition;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rel = new ArrayCollection();
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts->add($cart);
            $cart->addBook($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            $cart->removeBook($this);
        }

        return $this;
    }

    public function addRel(RelBookAuthor $rel): self
    {
        if (!$this->rel->contains($rel)) {
            $this->rel->add($rel);
            $rel->setBooks($this);
        }

        return $this;
    }

    public function removeRel(RelBookAuthor $rel): self
    {
        if ($this->rel->removeElement($rel)) {
            // set the owning side to null (unless already changed)
            if ($rel->getBooks() === $this) {
                $rel->setBooks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RelBookAuthor>
     */
    public function getRel(): Collection
    {
        return $this->rel;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }
}
