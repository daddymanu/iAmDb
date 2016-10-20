<?php

namespace MyApp\FilmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="MyApp\FilmsBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @Assert\Length(min=3, minMessage="categorie.nom.minlength")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_fr", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="categorie.nom.minlength")
     */
    private $nom_fr;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom_es", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="categorie.nom.minlength")
     */
    private $nom_es;    
    /**
     * @var string
     *
     * @ORM\Column(name="nom_de", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="categorie.nom.minlength")
     */
    private $nom_de;

    /**
    * @ORM\OneToMany(targetEntity="Film", cascade={"persist"}, mappedBy="categorie")
    * @ORM\OrderBy({"titre" = "asc"})
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
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Categorie
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

    public function __toString()
    {
        return $this->getNom();
    }
    
    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Categorie
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
     * @return Categorie
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
     * @return Categorie
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


    /**
     * Set nomFr
     *
     * @param string $nomFr
     *
     * @return Categorie
     */
    public function setNomFr($nomFr)
    {
        $this->nom_fr = $nomFr;

        return $this;
    }

    /**
     * Get nomFr
     *
     * @return string
     */
    public function getNomFr()
    {
        return $this->nom_fr;
    }

    /**
     * Set nomEs
     *
     * @param string $nomEs
     *
     * @return Categorie
     */
    public function setNomEs($nomEs)
    {
        $this->nom_es = $nomEs;

        return $this;
    }

    /**
     * Get nomEs
     *
     * @return string
     */
    public function getNomEs()
    {
        return $this->nom_es;
    }

    /**
     * Set nomDe
     *
     * @param string $nomDe
     *
     * @return Categorie
     */
    public function setNomDe($nomDe)
    {
        $this->nom_de = $nomDe;

        return $this;
    }

    /**
     * Get nomDe
     *
     * @return string
     */
    public function getNomDe()
    {
        return $this->nom_de;
    }
}
