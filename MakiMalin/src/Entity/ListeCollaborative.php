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
    private ?ListeDeCourses $liste_id = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'listesCollaborative')]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListeId(): ?ListeDeCourses
    {
        return $this->liste_id;
    }

    public function setListeId(?ListeDeCourses $liste_id): static
    {
        $this->liste_id = $liste_id;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurId(): Collection
    {
        return $this->utilisateur_id;
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
