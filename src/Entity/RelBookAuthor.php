<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RelBookAuthor
 *
 * @ORM\Table(name="RelBookAuthor")
 * @ORM\Entity(repositoryClass="App\Entity\RelBookAuthorRepository")
 */
class RelBookAuthor
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="rel")
     */
    private $books;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="rel")
     */
    private $authors;

    /**
     * @var string
     *
     * @ORM\Column(name="authorType", type="string", length=4)
     */
    private $authorType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setAuthorType(string $authorType): self
    {
        $this->authorType = $authorType;

        return $this;
    }

    public function getAuthorType(): ?string
    {
        return $this->authorType;
    }

    public function setBooks(?Book $books): self
    {
        $this->books = $books;

        return $this;
    }

    public function getBooks(): ?Book
    {
        return $this->books;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    public function getAuthors(): ?Author
    {
        return $this->authors;
    }

    public function setAuthors(?Author $authors): self
    {
        $this->authors = $authors;

        return $this;
    }
}
