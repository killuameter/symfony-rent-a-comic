<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="Cart")
 * @ORM\Entity(repositoryClass="App\Entity\CartRepository")
 */
class Cart
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="carts")
     */
    private $books;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="carts")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PickupSpot", inversedBy="carts")
     */
    private $pickup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fine", mappedBy="cart")
     */
    private $fines;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime")
     */
    private $dateModified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="totalAmont", type="float" ,nullable=true)
     */
    private $totalAmont;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateToBeReturn", type="datetime", nullable=true)
     */
    private $dateToBeReturn;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReallyReturned", type="datetime", nullable=true)
     */
    private $dateReallyReturned;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setTotalAmont(?float $totalAmont): self
    {
        $this->totalAmont = $totalAmont;

        return $this;
    }

    public function getTotalAmont(): ?float
    {
        return $this->totalAmont;
    }

    public function setDateToBeReturn(?\DateTimeInterface $dateToBeReturn): self
    {
        $this->dateToBeReturn = $dateToBeReturn;

        return $this;
    }

    public function getDateToBeReturn(): ?\DateTimeInterface
    {
        return $this->dateToBeReturn;
    }

    /**
     * Set books
     *
     * @param integer $books
     * @return Cart
     */
    public function setBooks($books): Cart
    {
        $this->books = $books;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setPickup(?PickupSpot $pickup): self
    {
        $this->pickup = $pickup;

        return $this;
    }

    public function getPickup(): ?PickupSpot
    {
        return $this->pickup;
    }

    /**
     * Set fines
     *
     * @param integer $fines
     * @return Cart
     */
    public function setFines($fines): Cart
    {
        $this->fines = $fines;

        return $this;
    }

    /**
     * @return Collection<int, Fine>
     */
    public function getFines(): Collection
    {
        return $this->fines;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->books = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        $this->books->removeElement($book);

        return $this;
    }

    public function addFine(Fine $fine): self
    {
        if (!$this->fines->contains($fine)) {
            $this->fines->add($fine);
            $fine->setCart($this);
        }

        return $this;
    }

    public function removeFine(Fine $fine): self
    {
        if ($this->fines->removeElement($fine)) {
            // set the owning side to null (unless already changed)
            if ($fine->getCart() === $this) {
                $fine->setCart(null);
            }
        }

        return $this;
    }

    public function setDateReallyReturned(?\DateTimeInterface $dateReallyReturned): self
    {
        $this->dateReallyReturned = $dateReallyReturned;

        return $this;
    }

    public function getDateReallyReturned(): ?\DateTimeInterface
    {
        return $this->dateReallyReturned;
    }
}
