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

    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    private Collection $utilisateur_id;

    public function __construct()
    {
        $this->utilisateur_id = new ArrayCollection();
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
}
