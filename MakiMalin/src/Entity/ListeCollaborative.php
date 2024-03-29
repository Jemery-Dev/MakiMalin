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

    #[ORM\OneToOne]
    private ?ListeDeCourses $listeDeCourses = null;

    
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'listesCollaborative')]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListeDeCourses(): ?ListeDeCourses
    {
        return $this->listeDeCourses;
    }

    public function setListeDeCourses(?ListeDeCourses $listeDeCourses): static
    {
        $this->listeDeCourses = $listeDeCourses;

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
