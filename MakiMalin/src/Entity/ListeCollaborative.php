<?php

namespace App\Entity;

use App\Repository\ListeCollaborativeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeCollaborativeRepository::class)]
class ListeCollaborative
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ListeDeCourses $liste = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    private Collection $utilisateur_id;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'listesCollaborative')]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->utilisateur_id = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListe(): ?ListeDeCourses
    {
        return $this->liste;
    }

    public function setListe(?ListeDeCourses $liste): static
    {
        $this->liste = $liste;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurId(): Collection
    {
        return $this->utilisateur_id;
    }

    public function addUtilisateurId(Utilisateur $utilisateurId): static
    {
        if (!$this->utilisateur_id->contains($utilisateurId)) {
            $this->utilisateur_id->add($utilisateurId);
        }

        return $this;
    }

    public function removeUtilisateurId(Utilisateur $utilisateurId): static
    {
        $this->utilisateur_id->removeElement($utilisateurId);

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addListesCollaborative($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeListesCollaborative($this);
        }

        return $this;
    }
}
