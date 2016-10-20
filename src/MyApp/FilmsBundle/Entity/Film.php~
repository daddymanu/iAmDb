<?php

namespace MyApp\FilmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="MyApp\FilmsBundle\Repository\FilmRepository")
 */
class Film
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="film.titre.minlength")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min = 1895, max = 2030)
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", cascade={"persist"}, inversedBy="films")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */    
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Acteur", inversedBy="films")
     * @ORM\JoinTable(name="film_acteur")
     */    
    private $acteurs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
        $this->acteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Film
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Film
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Film
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set categorie
     *
     * @param \MyApp\FilmsBundle\Entity\Categorie $categorie
     *
     * @return Film
     */
    public function setCategorie(\MyApp\FilmsBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \MyApp\FilmsBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add acteur
     *
     * @param \MyApp\FilmsBundle\Entity\Acteur $acteur
     *
     * @return Film
     */
    public function addActeur(\MyApp\FilmsBundle\Entity\Acteur $acteur)
    {
        $this->acteurs[] = $acteur;

        return $this;
    }

    /**
     * Remove acteur
     *
     * @param \MyApp\FilmsBundle\Entity\Acteur $acteur
     */
    public function removeActeur(\MyApp\FilmsBundle\Entity\Acteur $acteur)
    {
        $this->acteurs->removeElement($acteur);
    }

    /**
     * Get acteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActeurs()
    {
        return $this->acteurs;
    }
}
