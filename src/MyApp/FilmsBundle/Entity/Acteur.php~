<?php

namespace MyApp\FilmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Acteur
 *
 * @ORM\Table(name="acteur")
 * @ORM\Entity(repositoryClass="MyApp\FilmsBundle\Repository\ActeurRepository")
 */
class Acteur
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
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, minMessage="acteur.nom.minlength")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, minMessage="acteur.prenom.minlength")
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     * @Assert\NotBlank()
     */
    private $dateNaissance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMort", type="date", nullable=true)
     */
    private $dateMort;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1)
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"M", "F"})
     */
    private $sexe;

    /**
     * @ORM\ManyToMany(targetEntity="Film", mappedBy="acteurs")
     */    
    private $films;

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
        $this->setDateNaissance(new \DateTime());
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
        $this->films = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Acteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Acteur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    

    public function getFullName()
    {
        return $this->prenom.' '.$this->nom;
    }

    public function __toString()
    {
        return $this->prenom.' '.$this->nom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Acteur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateMort
     *
     * @param \DateTime $dateMort
     *
     * @return Acteur
     */
    public function setDateMort($dateMort)
    {
        $this->dateMort = $dateMort;

        return $this;
    }

    /**
     * Get dateMort
     *
     * @return \DateTime
     */
    public function getDateMort()
    {
        return $this->dateMort;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Acteur
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Acteur
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
     * @return Acteur
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
     * Add film
     *
     * @param \MyApp\FilmsBundle\Entity\Film $film
     *
     * @return Acteur
     */
    public function addFilm(\MyApp\FilmsBundle\Entity\Film $film)
    {
        $this->films[] = $film;

        return $this;
    }

    /**
     * Remove film
     *
     * @param \MyApp\FilmsBundle\Entity\Film $film
     */
    public function removeFilm(\MyApp\FilmsBundle\Entity\Film $film)
    {
        $this->films->removeElement($film);
    }

    /**
     * Get films
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilms()
    {
        return $this->films;
    }
}
