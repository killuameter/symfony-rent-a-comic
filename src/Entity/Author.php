<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Author
 *
 * @ORM\Table(name="Author")
 * @ORM\Entity(repositoryClass="App\Entity\AuthorRepository")
 */
class Author
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
     * @ORM\OneToMany(targetEntity="App\Entity\RelBookAuthor", mappedBy="authors")
     */
    private $rel;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deathDate", type="datetime", nullable=true)
     */
    private $deathDate;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set Id
     * @param integer $id
     * @return Author
     */
    public function setId($id): Author
    {
        $this->id = $id;

        return $this;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setDeathDate(?\DateTimeInterface $deathDate): self
    {
        $this->deathDate = $deathDate;

        return $this;
    }

    public function getDeathDate(): ?\DateTimeInterface
    {
        return $this->deathDate;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
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

    /**
     * Set rel
     *
     * @param integer $rel
     * @return Author
     */
    public function setRel($rel): Author
    {
        $this->rel = $rel;

        return $this;
    }

    /**
     * @return Collection<int, RelBookAuthor>
     */
    public function getRel(): Collection
    {
        return $this->rel;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addRel(RelBookAuthor $rel): self
    {
        if (!$this->rel->contains($rel)) {
            $this->rel->add($rel);
            $rel->setAuthors($this);
        }

        return $this;
    }

    public function removeRel(RelBookAuthor $rel): self
    {
        if ($this->rel->removeElement($rel)) {
            // set the owning side to null (unless already changed)
            if ($rel->getAuthors() === $this) {
                $rel->setAuthors(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
}
