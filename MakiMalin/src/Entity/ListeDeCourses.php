<?php

namespace App\Entity;

use App\Repository\ListeDeCoursesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeDeCoursesRepository::class)]
class ListeDeCourses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne]
    private ?Utilisateur $proprietaire_id = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'liste_id', orphanRemoval: true)]
    private Collection $courses;

    #[ORM\ManyToOne(inversedBy: 'listesDeCourse')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getProprietaireId(): ?Utilisateur
    {
        return $this->proprietaire_id;
    }

    public function setProprietaireId(?Utilisateur $proprietaire_id): static
    {
        $this->proprietaire_id = $proprietaire_id;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setListeId($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getListeId() === $this) {
                $course->setListeId(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
